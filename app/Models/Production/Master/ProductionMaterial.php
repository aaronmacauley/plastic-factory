<?php

namespace App\Models\Production\Master;

use App\Models\Inventory\Item\Item;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    protected $table = 'production_materials';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'production_id',
        'item_id',
        'bom_id',

        // ✅ PLANNED
        'planned_qty',
        'planned_unit_cost',
        'planned_total_cost',

        // ✅ ACTUAL
        'actual_qty',
        'actual_unit_cost',
        'actual_total_cost',

        // ✅ VARIANCE
        'variance_qty',
        'variance_cost',
    ];

    protected $casts = [
        'planned_qty' => 'float',
        'planned_unit_cost' => 'float',
        'planned_total_cost' => 'float',

        'actual_qty' => 'float',
        'actual_unit_cost' => 'float',
        'actual_total_cost' => 'float',

        'variance_qty' => 'float',
        'variance_cost' => 'float',
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
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function production()
    {
        return $this->belongsTo(Productions::class);
    }

    public function material()
    {
        return $this->belongsTo(Item::class);
    }
}
