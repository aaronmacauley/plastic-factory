<?php

namespace App\Http\Controllers\Production\Master;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Item\Item;
use App\Models\Production\Bom\Bom;
use App\Models\Production\Master\Productions;
use App\Services\Production\Master\ProductionService;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    protected $service;

    // ================= LIST =================
    public function index()
    {
        $productions = Productions::with('item')->latest()->get();
        return view('production.master.index', compact('productions'));
    }

    // ================= CREATE =================
    public function create()
    {
        $items = Item::where('type', 'finished')->get();
        $boms = Bom::where('is_active', 1)->get();

        return view('production.master.create', compact('items', 'boms'));
    }
    public function __construct(ProductionService $service)
    {
        $this->service = $service;
    }



    public function store(Request $request)
    {
        $this->service->store($request->all());

        return redirect()->back()->with('success', 'Production created');
    }
    public function start($id)
    {
        $this->service->start($id);
        return back()->with('success', 'Production started');
    }

    public function finish($id)
    {
        $this->service->finish($id);
        return back()->with('success', 'Production finished');
    }
    public function getBomByItem($itemId)
    {
        return response()->json(
            Bom::where('item_id', $itemId)
                ->where('is_active', 1)
                ->get()
        );
    }

    public function getBom($id)
    {
        $bom = Bom::with(['details.item', 'operations.machine'])
            ->find($id);

        if (!$bom) {
            return response()->json([]);
        }

        return response()->json($bom);
    }

}

