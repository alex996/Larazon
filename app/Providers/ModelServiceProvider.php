<?php

namespace App\Providers;

use App\Models\{Product, Category};
use Illuminate\Support\ServiceProvider;
use App\Observers\{ProductObserver, CategoryObserver};
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
