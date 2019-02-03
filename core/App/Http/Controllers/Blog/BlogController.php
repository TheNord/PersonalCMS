<?php

namespace App\Http\Controllers\Blog;



use App\ReadModel\Pagination;
use App\ReadModel\PostReadRepository;
use Slim\Exception\NotFoundException;

class BlogController
{
    private const PER_PAGE = 5;

    protected $view;
    protected $posts;

    public function __construct(\Slim\Container $container) {
        $this->view = $container->get('view');
        $this->posts = new PostReadRepository($container);
    }

    public function index($request, $response) {
        $pager = new Pagination(
        // получаем общее количество постов
            $this->posts->countAll(),
            // получаем из реквеста атрибут page
            $request->getAttribute('page') ?: 1,
            // задаем число записей на странице
            self::PER_PAGE
        );

        $posts = $this->posts->all(
            $pager->getOffset(),
            $pager->getLimit()
        );

        return $this->view->render($response, 'app/blog/index.html.twig', [
            'posts' => $posts,
            'pager' => $pager,
        ]);
    }


    public function show($request, $response)
    {
        if (!$post = $this->posts->find($request->getAttribute('id'))) {
            throw new NotFoundException($request, $response);
        }

        return $this->view->render($response, 'app/blog/show.html.twig', [
            'post' => $post
        ]);
    }
}