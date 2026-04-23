<?php

namespace App\Models\Production\Master;

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
        'material_id',
        'qty',
        'cost'
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

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
