<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\{Address, Card, Cart, Category, Product, User};
use App\Observers\{AddressObserver, CardObserver, CartObserver, CategoryObserver, ProductObserver, UserObserver};

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->defineMorphMap();

        $this->bootObservers();
    }

    /**
     * Defines names for polymorphic types.
     * 
     * @return void
     */
    protected function defineMorphMap()
    {
        Relation::morphMap([
            'users' => User::class,
            'cards' => Card::class,
        ]);
    }

    /**
     * Registers model observers.
     * 
     * @return void
     */
    protected function bootObservers()
    {
        Product::observe(ProductObserver::class);

        Category::observe(CategoryObserver::class);

        Cart::observe(CartObserver::class);

        User::observe(UserObserver::class);

        Card::observe(CardObserver::class);

        Address::observe(AddressObserver::class);
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
