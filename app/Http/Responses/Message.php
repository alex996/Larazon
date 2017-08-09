<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Routing\ResponseFactory;

class Message
{
    /**
     * Bind the macro to the Response factory.
     * 
     * @param  ResponseFactory $factory
     * @return Response
     */
    public function bind(ResponseFactory $factory)
    {
        $factory->macro('message', function (string $message, $status = 200, array $headers = [], $options = 0) use ($factory) {
            return $factory->json([
                'message' => $message
            ], $status, $headers, $options);
        });
    }
}