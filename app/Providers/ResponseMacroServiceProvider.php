<?php

namespace App\Providers;

use App\Http\Responses;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Response macros.
     * 
     * @var array
     */
    protected $macros = [
        Responses\Standard\SuccessMacro::class,
        Responses\Standard\ErrorMacro::class,
        Responses\Fractal\ItemMacro::class,
        Responses\Fractal\CollectionMacro::class,
        Responses\Fractal\PaginatorMacro::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $this->bindMacros($factory);
    }

    /**
     * Bind Response macros to the factory.
     * 
     * @param  ResponseFactory $factory
     * @return void
     */
    protected function bindMacros(ResponseFactory $factory)
    {
        foreach ($this->macros as $macro) {
            $this->app->make($macro)->bind($factory);
        }
    }
}
