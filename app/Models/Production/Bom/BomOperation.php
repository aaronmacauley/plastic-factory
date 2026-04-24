<?php

namespace App\Models\Production\Bom;

use App\Models\Production\Machine\Machine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BomOperation extends Model
{
    use HasFactory;

    protected $table = 'bom_operations';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'bom_id',
        'machine_id',
        'sequence',
        'hours',
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

    // 🔗 ke BOM
    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }

    // 🔗 ke Machine
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
