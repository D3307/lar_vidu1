<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // cho phép mass assignment cho các trường cần thiết
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
}