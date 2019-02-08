<?php

namespace Framework\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

class ErrorHandlerMiddleware
{
    private $debug;

    public function __construct(\Slim\Container $container)
    {
        $this->debug = $container->get('settings')['debug'];
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, $next)
    {
        if (!$this->debug) {
            try {
                return $next($request, $response);
            } catch (NotFoundException $e) {
                $content = view('error/404');

                return $response->withStatus(404)
                    ->withHeader('Content-Type', 'text/html')
                    ->write($content);
            } catch (\Exception $e) {
                $content = view('error/500');

                return $response->withStatus(500)
                    ->withHeader('Content-Type', 'text/html')
                    ->write($content);
            }
        }
        return $next($request, $response);
    }
}
