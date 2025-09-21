<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Observers\ProductObserver;
use App\Models\Inventory;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        View::composer('*', function ($view) {
            $lowStockItems = Inventory::with('product')
                ->whereColumn('quantity', '<', 'min_quantity')
                ->get();
                
        $view->with('lowStockItems', $lowStockItems);
        });
    }
}
