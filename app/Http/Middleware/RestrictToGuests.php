<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RestrictToGuests extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($token = $this->auth->setRequest($request)->getToken()) {
            try {
                $user = $this->auth->authenticate($token);
            } catch (TokenExpiredException $e) {
                return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
            } catch (JWTException $e) {
                return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
            }

            if (! $user) {
                return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
            }

            throw new AccessDeniedHttpException;
        }

        return $next($request);
    }
}
