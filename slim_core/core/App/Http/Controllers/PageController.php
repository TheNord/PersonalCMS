<?php

namespace App\Http\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PageController
{
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return view('app/pages/index', ['host' => $request->getUri()->getHost()]);
    }

    public function editHome()
    {
        return view('app/pages/index');
    }
}
