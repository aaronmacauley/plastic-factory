<?php

namespace App\Http\Controllers\Production\Machine;

use App\Http\Controllers\Controller;
use App\Services\Production\Machine\MachineService;
use Illuminate\Http\Request;


class MachineController extends Controller
{
    protected $service;

    public function __construct(MachineService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $machines = $this->service->getAll();
 

        return view('production.machine.index', compact('machines'));
    }

    public function store(Request $request)
    {
        $this->service->store($request->all());
        return back()->with('success', 'Machine created');
    }

    public function update(Request $request, $id)
    {
        $this->service->update($id, $request->all());
        return back()->with('success', 'Machine updated');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return back()->with('success', 'Machine deleted');
    }
}
