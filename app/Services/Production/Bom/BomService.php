<?php

namespace App\Services\Production\Bom;

use App\Models\Production\Bom\Bom;
use App\Models\Production\Bom\BomDetails;
use App\Models\Production\Bom\BomOperation;
use DB;
class BomService
{
    public function getAll()
    {
        return Bom::with('item')->latest()->get();
    }

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $bom = Bom::create([
                'item_id' => $data['item_id'],
                'version' => $data['version'],
                'is_active' => $data['is_active'] ?? 1,
                'notes' => $data['notes'] ?? null
            ]);

            // MATERIALS
            if (!empty($data['details'])) {
                foreach ($data['details'] as $d) {
                    BomDetails::create([
                        'bom_id' => $bom->id,
                        'item_id' => $d['item_id'],
                        'unit_id' => $d['unit_id'],
                        'qty' => $d['qty']
                    ]);
                }
            }

            // OPERATIONS
            if (!empty($data['operations'])) {
                foreach ($data['operations'] as $o) {
                    BomOperation::create([
                        'bom_id' => $bom->id,
                        'machine_id' => $o['machine_id'],
                        'sequence' => $o['sequence'],
                        'hours' => $o['hours'],
                        'cost_per_hour' => $o['cost_per_hour']
                    ]);
                }
            }

            DB::commit();
            return $bom;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function find($id)
    {
        return Bom::with(['details.item', 'operations.machine'])->findOrFail($id);
    }
    public function update($id, $data)
    {
        DB::beginTransaction();

        try {
            $bom = Bom::findOrFail($id);

            $bom->update([
                'item_id' => $data['item_id'] ?? $bom->item_id,
                'version' => $data['version'] ?? $bom->version,
                'is_active' => $data['is_active'] ?? $bom->is_active,
                'notes' => $data['notes'] ?? null
            ]);

            // 🔥 DELETE OLD
            $bom->details()->delete();
            $bom->operations()->delete();

            // 🔥 INSERT NEW
            foreach ($data['details'] ?? [] as $d) {
                if (!isset($d['item_id']))
                    continue;

                \App\Models\Production\Bom\BomDetails::create([
                    'bom_id' => $bom->id,
                    'item_id' => $d['item_id'],
                    'unit_id' => $d['unit_id'] ?? null,
                    'qty' => $d['qty'] ?? 0
                ]);
            }

            foreach ($data['operations'] ?? [] as $o) {
                if (!isset($o['machine_id']))
                    continue;

                BomOperation::create([
                    'bom_id' => $bom->id,
                    'machine_id' => $o['machine_id'],
                    'sequence' => $o['sequence'] ?? 0,
                    'hours' => $o['hours'] ?? 0,
                    'cost_per_hour' => $o['cost_per_hour'] ?? 0
                ]);
            }

            DB::commit();

            return $bom;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}
