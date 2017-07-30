<?php

namespace App\Http\Responses\Standard;

use Illuminate\Contracts\Routing\ResponseFactory;

class SuccessMacro
{
    /**
     * Bind the macro to the Response factory.
     * 
     * @param  ResponseFactory $factory
     * @return Response
     */
    public function bind(ResponseFactory $factory)
    {
        $factory->macro('success', function ($data = [], $status = 200, array $headers = [], $options = 0) use ($factory) {
            return $factory->json([
                $data, $status, $headers, $options
            ], $status);
        });
    }
}