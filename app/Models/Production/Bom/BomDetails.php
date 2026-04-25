<?php

namespace App\Models\Production\Bom;

use App\Models\Inventory\Item\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class BomDetails extends Model
{
    use HasFactory;
    protected $table = 'bom_details';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'bom_id',
        'item_id',
        'qty'
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

    // 🔗 ke Item (material / sub assembly)
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
