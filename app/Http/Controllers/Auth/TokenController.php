<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\{HttpException, UnauthorizedHttpException};

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

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                throw new UnauthorizedHttpException;
            }
        } catch (JWTException $e) {
            throw new HttpException;
        }

        return Response::json(compact('token'));
    }
}
