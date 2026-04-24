<?php

namespace App\Http\Controllers\Inventory\Item;

use App\Http\Controllers\Controller;
use App\Models\Inventory\ItemUnit\ItemUnit;
use App\Services\Inventory\Item\ItemService;
use App\Services\Inventory\Unit\UnitService;
use DB;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    protected $service;
    protected $unitService;

    public function __construct(ItemService $service, UnitService $UnitService)
    {
        $this->service = $service;
        $this->unitService = $UnitService;
    }


    public function addUnit(Request $request, $id)
    {
        $request->validate([
            'unit_id' => 'required',
            'rate' => 'required'
        ]);

        $result = $this->service->addUnit($id, $request->all());

        return response()->json($result);
    }


    public function index()
    {
        $items = $this->service->getAll();
        $units = $this->unitService->getAll();

        return view('inventory.items.index', compact('items', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'units' => 'required|array',
            'units.*.unit_id' => 'required',
            'units.*.conversion_rate' => 'required',
            'base_unit' => 'required'
        ]);

        $this->service->store($request->all());

        return redirect()
            ->route('items.index')
            ->with('success', 'Item created successfully');
    }

    public function create()
    {
        $units = $this->unitService->getAll();
        return view('inventory.items.create', compact('units'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'unit_id' => 'required'
        ]);

        $this->service->update($id, $request->all());

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->back()->with('success', 'Item deleted');
    }
}
