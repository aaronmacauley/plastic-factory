<?php

namespace App\Services\Accounting\Journal;


use App\Models\Accounting\Journal\Journal;
use App\Models\Accounting\Journal\JournalDetails;
use Illuminate\Support\Str;
use DB;

class JournalService
{
    public function create($data)
    {
        return DB::transaction(function () use ($data) {

            $journal = Journal::create([
                'journal_number' => $this->generateNumber(),
                'transaction_date' => $data['transaction_date'],

                'description' => $data['description'],
                'reference_type' => $data['ref_type'] ?? null,
                'reference_id' => $data['ref_id'] ?? null,
                'status' => 'posted'
            ]);

            foreach ($data['lines'] as $line) {

                $debit = $line['debit'] ?? 0;
                $credit = $line['credit'] ?? 0;

                JournalDetails::create([
                    'journal_entry_id' => $journal->id,
                    'account_id' => $line['account_id'],
                    'description' => $line['description'] ?? null,
                    'amount' => $debit > 0 ? $debit : $credit,
                    'position' => $debit > 0 ? 'debit' : 'credit',
                ]);
            }


            return $journal;
        });
    }

    private function generateNumber()
    {
        return 'JR-' . date('Ymd-His');
    }
}
