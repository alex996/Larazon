<?php

namespace App\Http\Responses\Fractal;

use League\Fractal\Manager;
use App\Http\Responses\Macroable;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Routing\ResponseFactory;

class ItemMacro implements Macroable
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

        $factory->macro('item', function ($item, TransformerAbstract $transformer, $status = 200, array $headers = []) use ($fractal, $factory) {
            $resource = new Item($item, $transformer);

            return $factory->json(
                $fractal->createData($resource)->toArray(),
                $status,
                $headers
            );
        });
    }
}