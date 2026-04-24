<?php

namespace App\Services\Production\Machine;

use App\Models\Production\Machine\Machine;



class MachineService
{
    protected $model;

    public function __construct(Machine $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->latest()->get();
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $machine = $this->find($id);
        $machine->update($data);
        return $machine;
    }

    public function delete($id)
    {
        $machine = $this->find($id);
        return $machine->delete();
    }
}
