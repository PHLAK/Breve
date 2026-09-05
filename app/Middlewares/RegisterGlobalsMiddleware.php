<?php

declare(strict_types=1);

namespace App\Middlewares;

use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Views\Twig;

class RegisterGlobalsMiddleware
{
    #[Inject('authors_enabled')]
    private bool $authorsEnabled;

    #[Inject('tags_enabled')]
    private bool $tagsEnabled;

    #[Inject('posts_list_enabled')]
    private bool $postsListEnabled;

    public function __construct(
        private Twig $view,
    ) {}

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $twigEnvironment = $this->view->getEnvironment();

        $twigEnvironment->addGlobal('authors_enabled', $this->authorsEnabled);
        $twigEnvironment->addGlobal('tags_enabled', $this->tagsEnabled);
        $twigEnvironment->addGlobal('posts_list_enabled', $this->postsListEnabled);
        $twigEnvironment->addGlobal('current_url', $this->currentUrl($request));

        return $handler->handle($request);
    }

    private function currentUrl(Request $request): string
    {
        $uri = $request->getUri();

        if (empty($host = $uri->getHost())) {
            return $uri->getPath();
        }

        $port = $uri->getPort();
        $scheme = $uri->getScheme();

        if ($port === null || ($port === 80 && $scheme === 'http') || ($port === 443 && $scheme === 'https')) {
            return sprintf('%s://%s%s', $scheme, $host, $uri->getPath());
        }

        return sprintf('%s://%s:%s%s', $scheme, $host, $port, $uri->getPath());
    }
}
