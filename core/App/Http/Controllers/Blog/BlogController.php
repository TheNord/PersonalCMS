<?php

namespace App\Http\Controllers\Blog;

use App\ReadModel\Pagination;
use App\ReadModel\PostReadRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\NotFoundException;

class BlogController
{
    private const PER_PAGE = 5;

    protected $posts;

    public function __construct(ContainerInterface $container) {
        $this->posts = new PostReadRepository($container);
    }

    public function index(RequestInterface $request, ResponseInterface $response) {
        $pager = new Pagination(
            // get total posts count
            $this->posts->countAll(),
            // get current number page
            $request->getAttribute('page') ?: 1,
            // posts per page
            self::PER_PAGE
        );

        $posts = $this->posts->all(
            $pager->getOffset(),
            $pager->getLimit()
        );

        return view('app/blog/index', [
            'posts' => $posts,
            'pager' => $pager,
        ]);
    }

    public function show(RequestInterface $request, ResponseInterface $response)
    {
        if (!$post = $this->posts->find($request->getAttribute('id'))) {
            throw new NotFoundException($request, $response);
        }

        return view('app/blog/show', [
            'post' => $post
        ]);
    }
}