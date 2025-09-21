<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'inventory_id',
        'type',
        'quantity',
        'note'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}