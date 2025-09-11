<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_value', 
        'usage_limit', 'used_count', 'start_date', 'end_date'
    ];

    public function isValid()
    {
        $now = now();
        return
            ($this->start_date === null || $this->start_date <= $now) &&
            ($this->end_date === null || $this->end_date >= $now) &&
            ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }
}