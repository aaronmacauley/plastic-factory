<?php

namespace App\Models\Production\Bom;

use App\Models\Inventory\Item\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Bom extends Model
{
    use HasFactory;
    protected $table = 'boms';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'item_id',
        'version',
        'is_active',
        'notes'
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

    // 🔗 Relasi ke item (produk utama)
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // 🔗 Relasi ke detail (komponen)
    public function details()
    {
        return $this->hasMany(BomDetails::class);
    }

    // 🔗 Relasi ke operation (mesin)
    public function operations()
    {
        return $this->hasMany(BomOperation::class);
    }
}
