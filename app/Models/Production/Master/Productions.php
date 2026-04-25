<?php

namespace App\Models\Production\Master;

use App\Models\Accounting\Journal\Journal;
use App\Models\Inventory\Item\Item;
use App\Models\Production\Detail\ProductionDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
class Productions extends Model
{
    protected $table = 'productions';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'production_date',
        'item_id',
        'journal_id',
        'operator_name',
        'notes',
        'total_output',
        'total_material_cost',
        'total_machine_cost',
        'total_cost',
        // ✅ ESTIMATED
        'estimated_material_cost',
        'estimated_machine_cost',
        'estimated_total_cost',

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

    public function materials()
    {
        return $this->hasMany(ProductionMaterial::class, 'production_id');
    }

    public function details()
    {
        return $this->hasMany(ProductionDetails::class, 'production_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }


    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
