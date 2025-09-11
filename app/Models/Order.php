<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Coupon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'discount',
        'coupon_id',
        'total',
        'status',
        'payment_status',
        'payment_method'
    ];

    // 🔗 1 đơn hàng thuộc về 1 khách hàng (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 1 đơn hàng có nhiều sản phẩm
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Đánh giá (reviews)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    //Mã giảm giá
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}