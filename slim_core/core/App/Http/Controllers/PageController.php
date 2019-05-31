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

    public function edit(RequestInterface $request, ResponseInterface $response)
    {
        $page = $request->getAttribute('page');
        return view('app/pages/edit', ['pageName' => $page]);
    }

    public function editStart(RequestInterface $request, ResponseInterface $response)
    {
        $page = $request->getAttribute('page');

        session()->set('editing', true);

        $content = filesystem()->read("/templates/main/{$page}.html.twig");

        return view("app/pages/page", ['pageContent' => $content]);
    }

    public function store(RequestInterface $request, ResponseInterface $response)
    {
        $data = json_decode($request->getBody()->getContents());
        $content = $data->content;
        $page = $data->page;

        filesystem()->put("/templates/main/{$page}.html.twig", $content);
    }
}
