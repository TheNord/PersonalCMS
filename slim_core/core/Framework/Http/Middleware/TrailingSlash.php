<?php

namespace Framework\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

class TrailingSlash
{
    private $view;
    private $debug;

    public function __invoke(RequestInterface $request, ResponseInterface $response, $next)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        if ($path != '/' && substr($path, -1) == '/') {
            $uri = $uri->withPath(substr($path, 0, -1));

            if($request->getMethod() == 'GET') {
                return $response->withRedirect((string)$uri, 301);
            }
            else {
                return $next($request->withUri($uri), $response);
            }
        }

        return $next($request, $response);
    }
}
