<?php

namespace App\Services\Accounting\Accounts;

use App\Models\Accounting\Account\Account;
use DB;

class AccountService
{
    public function getAll()
    {
        return Account::orderBy('code')->get();
    }

    public function store(array $data)
    {
        DB::beginTransaction();

        try {

            $account = Account::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'type' => $data['type'],
                'parent_id' => $data['parent_id'] ?? null,
                'is_active' => $data['is_active'] ?? 1,
            ]);

            DB::commit();

            return $account;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        $account = Account::findOrFail($id);

        $account->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'type' => $data['type'],
            'parent_id' => $data['parent_id'] ?? null,
            'is_active' => $data['is_active'] ?? 1,
        ]);

        return $account;
    }

    public function delete($id)
    {
        return Account::findOrFail($id)->delete();
    }

    public function findById($id)
    {
        return Account::findOrFail($id);
    }
}
