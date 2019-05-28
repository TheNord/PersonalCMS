<?php

namespace App\Http\Middleware;

use Framework\Helpers\SessionHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $user = session()->get('user');

        if (!$user) {
            return redirect($response)->with('status', 'Authorization required')->route('login.index');
        }

        SessionHelper::regenerateId();

        return $next($request, $response);
    }
}
