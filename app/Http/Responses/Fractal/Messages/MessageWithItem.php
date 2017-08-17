<?php

namespace App\Http\Responses\Fractal\Messages;

use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item as FractalItem;
use Illuminate\Contracts\Routing\ResponseFactory;

class MessageWithItem
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

        $factory->macro('messageWithItem', function (
            string $message,
            $item,
            TransformerAbstract $transformer,
            $status = 200,
            array $headers = []
        ) use ($fractal, $factory) {
            $resource = new FractalItem($item, $transformer);

            return $factory->json(
                array_merge(
                    compact('message'),
                    $fractal->createData($resource)->toArray()
                ),
                $status,
                $headers
            );
        });
    }
}