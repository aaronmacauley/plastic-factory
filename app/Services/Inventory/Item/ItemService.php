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
            $item = $this->model->create($data);

            // save base unit
            ItemUnit::create([
                'item_id' => $item->id,
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
