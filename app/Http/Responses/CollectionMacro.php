<?php

namespace App\Http\Responses;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Routing\ResponseFactory;

class CollectionMacro
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

        $factory->macro('collection', function ($collection, TransformerAbstract $transformer, $status = 200, array $headers = []) use ($fractal, $factory) {
            $resource = new Collection($collection, $transformer);

            return $factory->json(
                $fractal->createData($resource)->toArray(),
                $status,
                $headers
            );
        });
    }
}