<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionDetails extends Model
{
    protected $table = 'production_details';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'production_id',
        'machine_id',
        'hours',
        'cost',
        'output'
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

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
