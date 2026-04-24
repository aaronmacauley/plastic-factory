<?php

namespace App\Http\Controllers\Production\Bom;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Item\Item;
use App\Models\Production\Bom\Bom;
use App\Models\Production\Machine\Machine;
use App\Services\Production\Bom\BomService;
use Illuminate\Http\Request;


class BomController extends Controller
{
    protected $service;

    public function __construct(BomService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $boms = $this->service->getAll();
        $items = Item::with('units')->get();
        $machines = Machine::all();

        return view('production.bom.index', compact('boms', 'items', 'machines'));
    }

    public function create()
    {
        $items = Item::with('units')->get(); // 🔥 penting
        $machines = Machine::all();
        return view('production.bom.create', compact('items', 'machines'));
    }

    public function store(Request $request)
    {

        $this->service->store($request->all());

        return redirect()->route('bom.index')
            ->with('success', 'BOM created');
    }
    public function show($id)
    {
        return Bom::with(['details.item.units', 'operations.machine'])->findOrFail($id);
    }
    public function update(Request $request, $id)
    {
        $this->service->update($id, $request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Bom::findOrFail($id)->delete();

        return redirect()->route('bom.index')
            ->with('success', 'BOM deleted');
    }


}

