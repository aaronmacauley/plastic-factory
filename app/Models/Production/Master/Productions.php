<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'total_cost'
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

    public function details()
    {
        return $this->hasMany(ProductionDetail::class);
    }

    public function materials()
    {
        return $this->hasMany(ProductionMaterial::class);
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
