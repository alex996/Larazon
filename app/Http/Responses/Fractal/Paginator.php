<?php

namespace App\Http\Responses\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Routing\ResponseFactory;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class Paginator
{
    /**
     * Fractal Manager.
     * 
     * @var Manager
     */
    protected $fractal;

    /**
     * Create a new macro instance.
     * 
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * Bind the macro to the Response factory.
     * 
     * @param  ResponseFactory $factory
     * @return Response
     */
    public function bind(ResponseFactory $factory)
    {
        $fractal = $this->fractal;

        $factory->macro('paginator', function ($paginator, TransformerAbstract $transformer, $status = 200, array $headers = []) use ($fractal, $factory) {
            $resource = new Collection($paginator->getCollection(), $transformer);
            $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

            return $factory->json(
                $fractal->createData($resource)->toArray(),
                $status,
                $headers
            );
        });
    }
}