<?php

namespace Framework\Http\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

class ErrorHandlerMiddleware
{
    private $view;
    private $debug;

    public function __construct(\Slim\Container $container)
    {
        $this->view = $container->get('view');
        $this->debug = $container->get('settings')['debug'];
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, $next)
    {
        if (!$this->debug) {
            try {
                return $next($request, $response);
            } catch (NotFoundException $e) {
                ob_start();
                $this->view->render($response, 'error/404.html.twig');
                $content = ob_get_clean();

                return $response->withStatus(404)
                    ->withHeader('Content-Type', 'text/html')
                    ->write($content);
            } catch (\Exception $e) {
                ob_start();
                $this->view->render($response, 'error/error.html.twig');
                $content = ob_get_clean();

                return $response->withStatus(500)
                    ->withHeader('Content-Type', 'text/html')
                    ->write($content);
            }
        }
        return $next($request, $response);
    }
}
