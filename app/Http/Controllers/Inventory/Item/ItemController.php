<?php

namespace App\Http\Controllers\Inventory\Item;

use App\Http\Controllers\Controller;
use App\Services\Inventory\Item\ItemService;
use App\Services\Inventory\Unit\UnitService;
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
            'unit_id' => 'required'
        ]);

        $this->service->store($request->all());

        return redirect()->back()->with('success', 'Item created successfully');
    }
    public function create()
    {
        return view('inventory.items.create');
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
