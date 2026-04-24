<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    protected $service;

    public function __construct(ProductionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $productions = $this->service->getAll();
        return view('production.index', compact('productions'));
    }

    public function create()
    {
        $items = Item::all();
        $boms = Bom::where('is_active', 1)->get();

        return view('production.create', compact('items', 'boms'));
    }

    public function store(Request $request)
    {
        $this->service->store($request->all());

        return redirect()->route('production.index')
            ->with('success', 'Production created');
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
}

