<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function issue(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if (! $token = JWTAuth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        return Response::json(compact('token'));
    }
}
