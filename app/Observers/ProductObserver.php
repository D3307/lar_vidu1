<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Inventory;

class ProductObserver
{
    public function updated(Product $product)
    {
        // Khi số lượng sản phẩm thay đổi
        if ($product->isDirty('quantity')) {
            Inventory::updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $product->quantity]
            );
        }
    }
}