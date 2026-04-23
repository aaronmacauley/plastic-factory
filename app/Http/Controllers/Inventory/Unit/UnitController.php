<?php

namespace App\Http\Controllers\Inventory\Unit;

use App\Http\Controllers\Controller;
use App\Services\Inventory\Unit\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    //
    protected $service;

    public function __construct(UnitService $service)
    {
        $this->service = $service;
    }

    /**
     * LIST
     */
    public function index()
    {
        $units = $this->service->getAll();

        return view('inventory.units.index', compact('units'));
    }

    /**
     * CREATE FORM
     */
    public function create()
    {
        return view('inventory.units.create');
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:units,code',
            'name' => 'required'
        ]);

        $this->service->store($request->all());

        return redirect()->route('units.index')->with('success', 'Unit created successfully');
    }

    /**
     * EDIT FORM
     */
    public function edit($id)
    {
        $unit = $this->service->findById($id);

        return view('inventory.units.edit', compact('unit'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:units,code,' . $id,
            'name' => 'required'
        ]);

        $this->service->update($id, $request->all());

        return redirect()->route('units.index')->with('success', 'Unit updated successfully');
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully');
    }
}
