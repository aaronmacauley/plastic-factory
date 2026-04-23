<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journals';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'journal_number',
        'transaction_date',
        'description',
        'reference_type',
        'reference_id',
        'status'
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

    public function lines()
    {
        return $this->hasMany(JournalDetails::class, 'journal_entry_id');
    }
}
