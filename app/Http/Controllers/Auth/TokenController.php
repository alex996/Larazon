<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TokenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return  @void
     */
    public function __construct() {
        $this->middleware('jwt.guest')->only('issue');
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
