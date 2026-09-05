<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Data\Post;
use App\Posts;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class PostsController
{
    public function __construct(
        private Posts $posts,
        private Twig $view,
    ) {}

    public function __invoke(Response $response): ResponseInterface
    {
        /** @var Collection<string, Post> $posts */
        $posts = $this->posts->all()->collect();

        if ($posts->isEmpty()) {
            return $this->view->render($response, 'error.twig', ['message' => 'No posts found']);
        }

        return $this->view->render($response, 'posts.twig', [
            'posts' => $posts->groupBy(fn (Post $post): int => $post->published->year, true),
            'count' => $posts->count(),
        ]);
    }
}
