<?php

declare(strict_types=1);

namespace App\Managers;

use App\Controllers;
use DI\Attribute\Inject;
use DI\Container;
use Slim\App;

class RouteManager
{
    /** @var App<Container> $app */
    #[Inject(App::class)]
    private App $app;

    #[Inject('authors_enabled')]
    private bool $authorsEnabled;

    #[Inject('tags_enabled')]
    private bool $tagsEnabled;

    #[Inject('posts_list_enabled')]
    private bool $postsListEnabled;

    /** @var array{pages: array<string,string>, posts: array<string,string>} */
    #[Inject('redirects')]
    private array $redirects;

    public function __invoke(): void
    {
        foreach ($this->redirects['pages'] as $old => $new) {
            $this->app->redirect(sprintf('/page/%s', $old), sprintf('/page/%s', $new), 301);
        }

        foreach ($this->redirects['posts'] as $old => $new) {
            $this->app->redirect(sprintf('/post/%s', $old), sprintf('/post/%s', $new), 301);
        }

        $this->app->get('/[{page:[0-9]+}]', Controllers\IndexController::class)->setName('index');
        $this->app->get('/post/{slug}', Controllers\PostController::class)->setName('post');
        $this->app->get('/page/{slug}', Controllers\PageController::class)->setName('page');
        $this->app->get('/author/{author}[/{page:[0-9]+}]', Controllers\AuthorController::class)->setName('author');
        $this->app->get('/tag/{tag}[/{page:[0-9]+}]', Controllers\TagController::class)->setName('tag');
        $this->app->get('/search', Controllers\SearchController::class)->setName('search');
        $this->app->get('/feed', Controllers\FeedController::class)->setName('feed');

        if ($this->postsListEnabled) {
            $this->app->get('/posts', Controllers\PostsController::class)->setName('posts');
        }

        if ($this->authorsEnabled) {
            $this->app->get('/authors', Controllers\AuthorsController::class)->setName('authors');
        }

        if ($this->tagsEnabled) {
            $this->app->get('/tags', Controllers\TagsController::class)->setName('tags');
        }

        $this->app->get('/theme/css/{stylesheet}', Controllers\Themes\CssController::class)->setName('theme.css');
        $this->app->get('/theme/js/{script}', Controllers\Themes\JsController::class)->setName('theme.js');
    }
}
