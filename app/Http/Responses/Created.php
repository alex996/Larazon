<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Routing\ResponseFactory;

class Created
{
    /**
     * Bind the macro to the Response factory.
     * 
     * @param  ResponseFactory $factory
     * @return Response
     */
    public function bind(ResponseFactory $factory)
    {
        $factory->macro('created', function (string $message, array $headers = [], $options = 0) use ($factory) {
            return $factory->message($message, 201, $headers, $options);
        });
    }
}