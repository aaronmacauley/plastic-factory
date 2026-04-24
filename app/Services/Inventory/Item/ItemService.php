<?php

namespace App\Services\Inventory\Item;

use App\Models\Inventory\Item\Item;
use App\Models\Inventory\ItemUnit\ItemUnit;
use DB;

class ItemService
{
    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }


    public function addUnit($itemId, array $data)
    {
        DB::beginTransaction();

        try {

            $item = Item::findOrFail($itemId);

            // cek duplicate
            if (
                ItemUnit::where('item_id', $itemId)
                    ->where('unit_id', $data['unit_id'])
                    ->exists()
            ) {

                return [
                    'success' => false,
                    'message' => 'Unit already exists'
                ];
            }

            // reset base unit kalau dipilih
            if (!empty($data['base'])) {
                ItemUnit::where('item_id', $itemId)
                    ->update(['is_base_unit' => 0]);
            }

            // 🔥 IMPORTANT: pakai MODEL, bukan attach
            ItemUnit::create([
                'item_id' => $itemId,
                'unit_id' => $data['unit_id'],
                'conversion_rate' => $data['rate'],
                'is_base_unit' => !empty($data['base']) ? 1 : 0
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Unit added successfully'
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getAll()
    {
        return $this->model->with('units')->latest()->get();

    }

    public function findById($id)
    {
        return $this->model->with('units')->findOrFail($id);
    }
    public function store(array $data)
    {
        DB::beginTransaction();

        try {

            // 1. CREATE ITEM
            $item = $this->model->create($data);

            // 2. BASE UNIT INDEX
            $baseIndex = $data['base_unit'] ?? 0;

            // 3. INSERT ITEM UNITS
            foreach ($data['units'] as $index => $unit) {

                ItemUnit::create([
                    'item_id' => $item->id,
                    'unit_id' => $unit['unit_id'],
                    'conversion_rate' => $unit['conversion_rate'],
                    'is_base_unit' => ($index == $baseIndex)
                ]);
            }

            DB::commit();
            return $item;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $item = $this->findById($id);
            $item->update($data);

            // update base unit
            ItemUnit::where('item_id', $id)->delete();

            ItemUnit::create([
                'item_id' => $id,
                'unit_id' => $data['unit_id'],
                'conversion_rate' => 1,
                'is_base_unit' => true
            ]);

            DB::commit();
            return $item;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        $item = $this->findById($id);
        $item->delete();
    }
}
