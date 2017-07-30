<?php

namespace App\Http\Responses\Standard;

use Illuminate\Contracts\Routing\ResponseFactory;

class ErrorMacro
{
    /**
     * Bind the macro to the Response factory.
     * 
     * @param  ResponseFactory $factory
     * @return Response
     */
    public function bind(ResponseFactory $factory)
    {
        $factory->macro('error', function (string $message = 'Bad Request', $status = 400, array $headers = [], $options = 0) use ($factory) {
            return $factory->json([
                'error' => [
                    'message' => $message
                ],                
            ], $status);
        });
    }
}