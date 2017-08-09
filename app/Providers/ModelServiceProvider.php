<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{Cart, Category, Product, User};
use App\Observers\{CartObserver, CategoryObserver, ProductObserver, UserObserver};

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

        User::observe(UserObserver::class);
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
