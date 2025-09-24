<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'category_id',
        'description',
        'image',
        'size',
        'material',
        'color',
    ];

    // Quan hệ 1 sản phẩm có nhiều chi tiết sản phẩm
    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    // Quan hệ nhiều sản phẩm thuộc 1 danh mục
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    //Đánh giá
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    //Tồn kho
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }


    //Danh sách yêu thích
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}