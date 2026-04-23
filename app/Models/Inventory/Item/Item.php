<?php

namespace App\Models\Inventory\Item;

use App\Models\Inventory\Stock\Master\Stock;
use App\Models\Inventory\Unit\Unit;
use App\Models\Production\Bom;
use App\Models\Production\Master\Productions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Item extends Model
{
    protected $table = 'items';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'code',
        'name',
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

    public function boms()
    {
        return $this->hasMany(Bom::class);
    }

    // BOM aktif (helper)
    public function activeBom()
    {
        return $this->hasOne(Bom::class)->where('is_active', true);
    }
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'item_unit')
            ->withPivot('conversion_rate', 'is_base_unit')
            ->withTimestamps();
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function productions()
    {
        return $this->hasMany(Productions::class);
    }
}
