<?php

use Framework\Container;
use Psr\Http\Message\ResponseInterface;
use Framework\Redirector;

if (! function_exists('app')) {
    /**
     * Get the container instance or container dependency 
     *
     * @param string|null $dependency
     * @return string
     */
    function app($dependency = null)
    {
        if (is_null($dependency)) {
            return Container::getInstance();
        }
        
        return app()->get($dependency);
    }
}

if (! function_exists('dd')) {
    /**
     * Var dump and die process variable or text
     *
     * @param string|array|object $variable
     */
    function dd($variable)
    {
        die(var_dump($variable));
    }
}

if (! function_exists('redirect')) {
    /**
     * Get an instance of the redirector.
     *
     * @param  ResponseInterface $response
     * @param  string $url
     * @return Framework\Redirector | Psr\Http\Message\ResponseInterface
     */
    function redirect(ResponseInterface $response, $url = null)
    {
    	if (!is_null($url)) {
    		return $response->withStatus(302)->withHeader('Location', $url);
    	}

        return new Redirector($response);
    }
}

if (! function_exists('view')) {
    /**
     * Get the rendered view contents for the given view.
     *
     * @param string $name
     * @param array $data
     * @return string
     */
    function view($name, $data = [])
    {
        $renderer = app()->get('view');
        $extension = app()->get('settings')['templates']['extension'];
        return $renderer->fetch($name . $extension, $data);
    }
}

if (! function_exists('session')) {
    /**
     * Get current session or set value
     *
     * @param string $key
     * @param string|array $value
     * @return Aura\Session\SessionFactory
     */
    function session($key = null, $value = null)
    {
        $session = app()->get('session');

        if (!is_null($key)) {
            $session->set($key, $value);
        }

        return $session;
    }
}

if (! function_exists('flash')) {
    /**
     * Set flash message in session
     *
     * @param string $key
     * @param string|array $value
     * @return void
     */
    function flash($key, $value)
    {
        session()->setFlash($key, $value);
    }
}