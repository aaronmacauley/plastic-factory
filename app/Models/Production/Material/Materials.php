<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    protected $table = 'materials';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [

        'name',
        'cost_per_unit'
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

    public function productions()
    {
        return $this->hasMany(ProductionMaterial::class);
    }
}
