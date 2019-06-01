<?php

namespace App\Http\Middleware;

use App\Entity\User\User;
use App\ReadModel\Auth\UserRepository;
use Framework\Helpers\SessionHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Helpers\RequestHelper;

class AdminAccessMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        /** @var User $user */
        $authUser = session()->get('user');

        if ($authUser) {
            $repository = new UserRepository();
            $user = $repository->getByEmail($authUser->getEmail());
        }

        if ($user->checkAdminAccess()) {
            SessionHelper::regenerateId();
            return $next($request, $response);
        }

        if (RequestHelper::wantsJson($request)) {
            return $response->withStatus(401);
        }

        return redirect($response)->with('error', 'Недостаточно привелегий для доступа')->route('login.index');
    }
}
