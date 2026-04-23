<?php

namespace App\Models\Inventory\Unit;

use App\Models\Inventory\Item\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Unit extends Model
{

    protected $table = 'units';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'code',
        'name',
    ];

    /**
     * Auto generate UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * 🔗 Relationship (optional, but recommended)
     * One unit can be used by many items
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_unit')
            ->withPivot('conversion_rate', 'is_base_unit')
            ->withTimestamps();
    }
}
