<?php

namespace App\Models\Inventory\Stock\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $table = 'stock_movements';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'item_id',
        'type',
        'qty',
        'price',
        'journal_entry_id',
        'reference_type',
        'reference_id',
        'transaction_date'
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

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_entry_id');
    }
}
