<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'machines';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'machine_name',
        'cost_per_hour'
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

    public function productionDetails()
    {
        return $this->hasMany(ProductionDetail::class);
    }
}
