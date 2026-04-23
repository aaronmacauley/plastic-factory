<?php

namespace App\Services\Inventory\Unit;

use App\Models\Inventory\Unit\Unit;
use Illuminate\Support\Facades\DB;

class UnitService
{
    protected $model;

    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Find unit by ID
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Store new unit
     */
    public function store(array $data)
    {
        DB::beginTransaction();

        try {
            $unit = $this->model->create([
                'code' => $data['code'],
                'name' => $data['name'],
            ]);

            DB::commit();

            return $unit;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update unit
     */
    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {
            $unit = $this->findById($id);

            $unit->update([
                'code' => $data['code'],
                'name' => $data['name'],
            ]);

            DB::commit();

            return $unit;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete unit
     */
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $unit = $this->findById($id);

            // optional: cek relasi item biar ga kehapus kalau dipakai
            if ($unit->items()->exists()) {
                throw new \Exception('Unit is used by items and cannot be deleted');
            }

            $unit->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
