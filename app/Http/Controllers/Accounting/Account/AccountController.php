<?php

namespace App\Http\Controllers\Accounting\Account;

use App\Http\Controllers\Controller;
use App\Services\Accounting\Accounts\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $service;

    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $accounts = $this->service->getAll();

        return view('accounting.accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:accounts,code',
            'name' => 'required',
            'type' => 'required'
        ]);

        $this->service->store($request->all());

        return redirect()->back()->with('success', 'Account created');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'type' => 'required'
        ]);

        $this->service->update($id, $request->all());

        return redirect()->back()->with('success', 'Account updated');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->back()->with('success', 'Account deleted');
    }
}
