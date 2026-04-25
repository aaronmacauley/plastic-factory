<?php

namespace App\Http\Controllers\Accounting\Journal;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Account\Account;
use App\Models\Accounting\Journal\Journal;
use App\Services\Accounting\Journal\JournalService;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    protected $service;

    public function __construct(JournalService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $journals = Journal::with('lines.account')->latest()->get();

        return view('accounting.journal.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $accounts = Account::where('is_active', 1)->get();

        return view('accounting.journal.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required',
        ]);

        $this->service->create($request->all());

        return redirect()->route('journal.index')
            ->with('success', 'Journal created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
