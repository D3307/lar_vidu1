<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'order_id',
        'discount',
        'used_at'
    ];

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}