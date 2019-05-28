<?php

namespace Framework;

use Psr\Http\Message\ResponseInterface;

class Redirector
{
    protected $response;

    /**
     * Redirector constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Redirect user via route name
     *
     * @param string $name Router name
     * @return ResponseInterface
     */
    public function route($name): ResponseInterface
    {
        $router = Container::getInstance()->get('router');
        return redirect($this->response, $router->pathFor($name));
    }

    public function with($key, $value)
    {
        $session = Container::getInstance()->get('session');
        $session->setFlash($key, $value);

        return $this;
    }
}