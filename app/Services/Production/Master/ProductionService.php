<?php

namespace App\Services\Production\Master;

use App\Models\Production\Bom\Bom;
use App\Models\Production\Detail\ProductionDetails;
use App\Models\Production\Master\ProductionMaterial;
use App\Models\Production\Master\Productions;
use App\Services\Accounting\Journal\JournalService;
use Illuminate\Support\Str;
use DB;

class ProductionService
{
    protected $journalService;

    public function __construct(JournalService $journalService)
    {
        $this->journalService = $journalService;
    }

    // ================= CREATE =================
    public function store($data)
    {
        return DB::transaction(function () use ($data) {

            $bom = Bom::with(['details.item', 'operations.machine'])
                ->findOrFail($data['bom_id']);

            $estimatedMaterial = 0;
            $estimatedMachine = 0;

            // 🔥 HITUNG ESTIMASI MATERIAL
            foreach ($bom->details as $d) {
                $estimatedMaterial += $d->qty * $data['qty'] * $d->item->standard_cost;
            }

            // 🔥 HITUNG ESTIMASI MACHINE
            foreach ($bom->operations as $o) {
                $estimatedMachine += ($o->hours * $data['qty']) * ($o->cost_per_hour ?? 0);

            }

            $production = Productions::create([
                'production_date' => now(),
                'item_id' => $data['item_id'],
                'operator_name' => $data['operator_name'] ?? null,
                'total_output' => $data['qty'] ?? 1,

                // ✅ SIMPAN ESTIMASI
                'estimated_material_cost' => $estimatedMaterial,
                'estimated_machine_cost' => $estimatedMachine,
                'estimated_total_cost' => $estimatedMaterial + $estimatedMachine
            ]);

            // 🔥 DETAIL MATERIAL (ACTUAL nanti di finish)
            // 🔥 DETAIL MATERIAL (PLANNED)
            foreach ($bom->details as $d) {

                $qty = $d->qty * $data['qty'];
                $unit = $d->item->units()
                    ->wherePivot('unit_id', $d->unit_id)
                    ->first();

                $conversion = $unit->pivot->conversion_rate ?? 1;

                $unitCost = $d->item->standard_cost * $conversion;

                $total = $qty * $unitCost;

                ProductionMaterial::create([
                    'production_id' => $production->id,
                    'item_id' => $d->item_id,
                    'bom_id' => $bom->id,

                    // ✅ PLANNED
                    'planned_qty' => $qty,
                    'planned_unit_cost' => $unitCost,
                    'planned_total_cost' => $total,

                    // ✅ ACTUAL kosong dulu
                    'actual_qty' => null,
                    'actual_unit_cost' => null,
                    'actual_total_cost' => null,
                ]);
            }

            // 🔥 DETAIL MACHINE
            foreach ($bom->operations as $o) {

                $hours = $o->hours * $data['qty']; // 🔥 penting!

                ProductionDetails::create([
                    'production_id' => $production->id,
                    'machine_id' => $o->machine_id,
                    'hours' => $hours,
                    'cost' => $hours * ($o->cost_per_hour ?? 0), // ✅ isi juga
                ]);
            }

            return $production;
        });
    }


    // ================= START =================
    public function start($id)
    {
        $prod = Productions::findOrFail($id);

        $prod->update([
            'status' => 1 // in progress
        ]);

        return $prod;
    }

    // ================= FINISH =================
    public function finish($id)
    {
        return DB::transaction(function () use ($id) {

            $prod = Productions::with(['materials.item', 'details.machine'])
                ->findOrFail($id);

            $totalMaterial = 0;
            $totalMachine = 0;

            // 🔥 HITUNG MATERIAL COST REAL
            foreach ($prod->materials as $m) {

                $cost = $m->qty * $m->unit_cost;

                $m->update([
                    'cost' => $cost
                ]);

                $totalMaterial += $cost;
            }

            // 🔥 HITUNG MACHINE COST REAL
            foreach ($prod->details as $d) {

                $machineCost = $d->machine->cost_per_hour ?? 0;
                $cost = $d->hours * $machineCost;

                $d->update([
                    'cost' => $cost
                ]);

                $totalMachine += $cost;
            }

            $total = $totalMaterial + $totalMachine;

            // 🔥 UPDATE PRODUCTION
            $prod->update([
                'total_material_cost' => $totalMaterial,
                'total_machine_cost' => $totalMachine,
                'total_cost' => $total,
                'status' => 2 // finished
            ]);

            // 🔥 POST JOURNAL (BARU DI FINISH!)
            $journal = $this->journalService->create([
                'date' => now(),
                'description' => 'Production Finish',
                'ref_type' => 'production',
                'ref_id' => $prod->id,
                'lines' => [
                    [
                        'account_id' => 'WIP_ACCOUNT_ID',
                        'position' => 'debit',
                        'amount' => $total
                    ],
                    [
                        'account_id' => 'RAW_MATERIAL_ACCOUNT_ID',
                        'position' => 'credit',
                        'amount' => $totalMaterial
                    ],
                    [
                        'account_id' => 'MACHINE_COST_ACCOUNT_ID',
                        'position' => 'credit',
                        'amount' => $totalMachine
                    ]
                ]
            ]);

            $prod->update([
                'journal_id' => $journal->id
            ]);

            return $prod;
        });
    }
}
