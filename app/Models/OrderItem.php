<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'color',
        'size',
    ];

    // 🔗 Sản phẩm thuộc về 1 đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 🔗 Mỗi item liên kết tới 1 sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}