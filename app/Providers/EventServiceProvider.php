<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->interceptJwtEvents();
    }

    /**
     * Intercepts the JWT events and overwrites error responses.
     * 
     * @return void
     */
    protected function interceptJwtEvents()
    {
        Event::listen('tymon.jwt.absent', function () {
            return Response::message('Token Not Provided.', 400);
        });

        Event::listen('tymon.jwt.expired', function () {
            return Response::message('Token Expired.', 401);
        });

        Event::listen('tymon.jwt.invalid', function () {
            return Response::message('Token Invalid.', 401);
        });

        Event::listen('tymon.jwt.user_not_found', function () {
            return Response::message('User Not Found.', 404);
        });
    }
}
