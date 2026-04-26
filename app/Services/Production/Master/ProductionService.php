<?php

namespace App\Services\Production\Master;

use App\Models\Accounting\Account\Account;
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
            'status' => 1,
            'started_at' => now(),
        ]);
    }



    // ================= FINISH =================
public function finish($id, $request)
{
    $prod = Productions::findOrFail($id);

    $totalMaterial = 0;

    $wip = Account::where('code', '1410')->first();
    $fg  = Account::where('code', '1420')->first();

    if (!$wip || !$fg) {
        throw new \Exception("Account 1410 / 1420 belum ada");
    }

    foreach ($request['materials'] ?? [] as $m) {

        $material = ProductionMaterial::where('id', $m['production_material_id'])->first();

        if (!$material) {
            continue; // 🔥 skip kalau ga ketemu
        }

        $actualQty = (float) ($m['actual_qty'] ?? 0);
        $actualUnitCost = (float) ($m['actual_unit_cost'] ?? 0);

        $plannedQty = (float) ($m['planned_qty'] ?? 0);
        $plannedTotal = (float) ($m['planned_total_cost'] ?? 0);

        $actualTotal = $actualQty * $actualUnitCost;

        $material->update([
            'actual_qty' => $actualQty,
            'actual_unit_cost' => $actualUnitCost,
            'actual_total_cost' => $actualTotal,
            'variance_qty' => $actualQty - $plannedQty,
            'variance_cost' => $actualTotal - $plannedTotal,
        ]);

        $totalMaterial += $actualTotal;
    }

    $prod->update([
        'status' => 2,
        'finished_at' => now(),
        'total_material_cost' => $totalMaterial,
        'total_cost' => $totalMaterial,
    ]);

    $this->journalService->create([
        'transaction_date' => now(),
        'description' => "Production Finish - {$prod->production_number}",
        'ref_type' => 'production',
        'ref_id' => $prod->id,
        'lines' => [
            [
                'account_id' => $wip->id,
                'debit' => $totalMaterial,
                'credit' => 0,
                'description' => 'WIP Production'
            ],
            [
                'account_id' => $fg->id,
                'debit' => $actualTotal,
                'credit' => $totalMaterial,
                'description' => 'Inventory Output'
            ]
        ]
    ]);

    return back()->with('success', 'Production finished');
}



}
