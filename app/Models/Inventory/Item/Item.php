<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'code',
        'name',
        'unit_id',
        'size',
        'grade',
        'weight',
        'diameter',
        'standard_cost',
        'price',
        'is_active'
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

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }
}
