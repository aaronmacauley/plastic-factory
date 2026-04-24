<?php

namespace App\Services;

use App\Models\Production\Bom\Bom;
use App\Models\Production\Machine\ProductionDetails;
use App\Models\Production\Master\ProductionMaterial;
use App\Models\Production\Master\Productions;
use DB;

class ProductionService
{
    public function getAll()
    {
        return Productions::with(['item','bom'])->latest()->get();
    }

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $production = Productions::create([
                'item_id' => $data['item_id'],
                'bom_id' => $data['bom_id'],
                'qty' => $data['qty'],
                'status' => 0
            ]);

            $bom = Bom::with(['details','operations'])->findOrFail($data['bom_id']);

            // 👉 MATERIAL AUTO GENERATE
            foreach ($bom->details as $d) {
                ProductionMaterial::create([
                    'production_id' => $production->id,
                    'item_id' => $d->item_id,
                    'bom_id' => $bom->id,
                    'qty' => $d->qty * $data['qty'],
                    'cost' => 0
                ]);
            }

            // 👉 OPERATION AUTO GENERATE
            foreach ($bom->operations as $o) {
                ProductionDetails::create([
                    'production_id' => $production->id,
                    'machine_id' => $o->machine_id,
                    'hours' => $o->hours,
                    'cost' => $o->hours * $o->cost_per_hour
                ]);
            }

            DB::commit();
            return $production;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function start($id)
    {
        $prod = Productions::findOrFail($id);
        $prod->update(['status' => 1]);
        return $prod;
    }

    public function finish($id)
    {
        DB::beginTransaction();

        try {
            $prod = Productions::findOrFail($id);

            // 👉 nanti disini:
            // - reduce stock bahan
            // - add stock hasil

            $prod->update(['status' => 2]);

            DB::commit();
            return $prod;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
