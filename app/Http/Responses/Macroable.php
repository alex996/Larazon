<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Routing\ResponseFactory;

interface Macroable
{
    /**
     * Bind the macro to the Response factory.
     * @param  ResponseFactory $factory
     * @return void
     */
    public function bind(ResponseFactory $factory);
}