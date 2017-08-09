<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Routing\ResponseFactory;

class NoContent
{
    /**
     * Bind the macro to the Response factory.
     * 
     * @param  ResponseFactory $factory
     * @return Response
     */
    public function bind(ResponseFactory $factory)
    {
        $factory->macro('noContent', function (array $headers = [], $options = 0) use ($factory) {
            return $factory->json([], 204, $headers, $options);
        });
    }
}