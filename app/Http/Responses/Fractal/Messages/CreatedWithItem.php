<?php

namespace App\Http\Responses\Fractal\Messages;

use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Routing\ResponseFactory;

class CreatedWithItem
{
    /**
     * Bind the macro to the Response factory.
     * 
     * @param  ResponseFactory $factory
     * @return Response
     */
    public function bind(ResponseFactory $factory)
    {
        $factory->macro('createdWithItem', function (
            string $message,
            $item,
            TransformerAbstract $transformer,
            array $headers = []
        ) use ($factory) {
            return $factory->messageWithItem($message, $item, $transformer, 201, $headers);
        });
    }
}