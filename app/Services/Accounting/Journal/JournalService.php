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
                'id' => Str::uuid(),
                'journal_number' => $this->generateNumber(),
                'transaction_date' => $data['date'],
                'description' => $data['description'],
                'reference_type' => $data['ref_type'] ?? null,
                'reference_id' => $data['ref_id'] ?? null,
                'status' => 'posted'
            ]);

            foreach ($data['lines'] as $line) {
                JournalDetails::create([
                    'id' => Str::uuid(),
                    'journal_entry_id' => $journal->id,
                    'account_id' => $line['account_id'],
                    'position' => $line['position'],
                    'amount' => $line['amount'],
                    'description' => $line['description'] ?? null
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
