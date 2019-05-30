<?php

namespace App\Http\Middleware;

use Framework\Helpers\SessionHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Helpers\RequestHelper;

class AuthMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {

        $user = session()->get('user');

        if (!$user) {
            if (RequestHelper::wantsJson($request)) {
                return $response->withStatus(401);
            }

            return redirect($response)->with('error', 'Требуется авторизация')->route('login.index');
        }

        SessionHelper::regenerateId();

        return $next($request, $response);
    }
}
