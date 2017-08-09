<?php

namespace App\Providers;

use App\Http\Responses;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Response macros.
     * 
     * @var array
     */
    protected $macros = [
        Responses\Fractal\Item::class,
        Responses\Fractal\Collection::class,
        Responses\Fractal\Paginator::class,
        Responses\Created::class,
        Responses\Message::class,
        Responses\NoContent::class,
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
