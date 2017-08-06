<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function issue(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if (! $token = JWTAuth::attempt($credentials)) {
            throw new UnauthorizedHttpException('Bearer', 'Invalid email or password.');
        }

        return Response::json(compact('token'));
    }
}
