<?php

namespace App\Services\Accounting\Accounts;

use App\Models\Accounting\Account\Account;
use App\Models\Accounting\Journal\Journal;
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
                'normal_balance' => $data['normal_balance'] ?? (
                    in_array($data['type'], ['asset', 'expense']) ? 'debit' : 'credit'
                ),
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
            'normal_balance' => $data['normal_balance'] ?? $account->normal_balance,
            'parent_id' => $data['parent_id'] ?? null,
            'is_active' => $data['is_active'] ?? 1,
        ]);


        return $account;
    }

     public function getLedger($accountId = null, $from = null, $to = null)
    {
        $query = Journal::with(['lines.account']);

        if ($from) {
            $query->whereDate('transaction_date', '>=', $from);
        }

        if ($to) {
            $query->whereDate('transaction_date', '<=', $to);
        }

        $journals = $query->orderBy('transaction_date')->get();

        $ledger = [];

        foreach ($journals as $journal) {
            foreach ($journal->lines as $line) {

                if ($accountId && $line->account_id != $accountId) {
                    continue;
                }

                $acc = $line->account;

                if (!$acc) continue;

                $ledger[$acc->id]['account'] = $acc;
                $ledger[$acc->id]['lines'][] = [
                    'date' => $journal->transaction_date,
                    'journal_no' => $journal->journal_number,
                    'description' => $line->description,
                    'debit' => $line->position === 'debit' ? $line->amount : 0,
                    'credit' => $line->position === 'credit' ? $line->amount : 0,
                ];
            }
        }

        // hitung running balance
        foreach ($ledger as $key => $data) {

            $balance = 0;

            foreach ($data['lines'] as &$line) {
                $balance += $line['debit'] - $line['credit'];
                $line['balance'] = $balance;
            }

            $ledger[$key]['lines'] = $data['lines'];
        }

        return $ledger;
    }

    public function getAccounts()
    {
        return Account::orderBy('code')->get();
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
