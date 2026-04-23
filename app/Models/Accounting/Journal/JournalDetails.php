<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalDetails extends Model
{
    protected $table = 'journal_entry_lines';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'journal_entry_id',
        'account_id',
        'position',
        'amount',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_entry_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
