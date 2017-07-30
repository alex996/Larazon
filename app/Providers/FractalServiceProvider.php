<?php

namespace App\Providers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class FractalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $fractal = $this->app->make(Manager::class);

        Response::macro('item', function ($item, TransformerAbstract $transformer, int $status = 200, array $headers = []) use ($fractal) {
            $resource = new Item($item, $transformer);

            return Response::json(
                $fractal->createData($resource)->toArray(),
                $status,
                $headers
            );
        });

        Response::macro('collection', function ($collection, TransformerAbstract $transformer, int $status = 200, array $headers = []) use ($fractal) {
            $resource = new Collection($collection, $transformer);

            return Response::json(
                $fractal->createData($resource)->toArray(),
                $status,
                $headers
            );
        });

        Response::macro('paginator', function ($paginator, TransformerAbstract $transformer, int $status = 200, array $headers = []) use ($fractal) {
            $collection = $paginator->getCollection();
            $resource = new Collection($collection, $transformer);
            $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

            return Response::json(
                $fractal->createData($resource)->toArray(),
                $status,
                $headers
            );
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
