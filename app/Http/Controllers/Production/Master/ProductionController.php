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
    public function planning($id)
    {
        $prod = Productions::with([
            'materials.item',
            'details.machine'
        ])->findOrFail($id);

        return response()->json($prod);
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

        return redirect()
            ->route('production.index')
            ->with('success', 'Production berhasil dibuat');
    }
    public function start($id)
    {
        $this->service->start($id);
        return back()->with('success', 'Production started');
    }

    public function finish(Request $request)
    {
     
        $id = $request->id;

        $this->service->finish($id, $request->all());

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

