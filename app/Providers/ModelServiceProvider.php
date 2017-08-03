<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{Cart, CartItem, Category, Product};
use App\Repositories\Product\{ProductRepository, EloquentProductRepository};
use App\Repositories\Category\{CategoryRepository, EloquentCategoryRepository};
use App\Observers\{CartItemObserver, CartObserver, CategoryObserver, ProductObserver};

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);

        Category::observe(CategoryObserver::class);

        Cart::observe(CartObserver::class);

        CartItem::observe(CartItemObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
