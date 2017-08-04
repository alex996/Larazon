<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{Cart, Category, Product};
use App\Observers\{CartObserver, CategoryObserver, ProductObserver};
use App\Repositories\Product\{ProductRepository, EloquentProductRepository};
use App\Repositories\Category\{CategoryRepository, EloquentCategoryRepository};

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
