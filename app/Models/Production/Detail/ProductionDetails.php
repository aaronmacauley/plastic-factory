<?php

namespace App\Models\Production\Detail;

use App\Models\Production\Machine\Machine;
use App\Models\Production\Master\Productions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

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
        return $this->belongsTo(Productions::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }

}
