<?php

declare(strict_types=1);

namespace Tests\Managers;

use App\Controllers;
use App\Managers\RouteManager;
use DI\Container;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Slim\App;
use Slim\Interfaces\RouteInterface;
use Tests\TestCase;

#[CoversClass(RouteManager::class)]
class RouteManagerTest extends TestCase
{
    private const array ROUTES = [
        ['index', '/[{page:[0-9]+}]', Controllers\IndexController::class],
        ['post', '/post/{slug}', Controllers\PostController::class],
        ['page', '/page/{slug}', Controllers\PageController::class],
        ['author', '/author/{author}[/{page:[0-9]+}]', Controllers\AuthorController::class],
        ['tag', '/tag/{tag}[/{page:[0-9]+}]', Controllers\TagController::class],
        ['search', '/search', Controllers\SearchController::class],
        ['feed', '/feed', Controllers\FeedController::class],
        ['authors', '/authors', Controllers\AuthorsController::class],
        ['tags', '/tags', Controllers\TagsController::class],
        ['posts', '/posts', Controllers\PostsController::class],
        ['theme.css', '/theme/css/{stylesheet}', Controllers\Themes\CssController::class],
        ['theme.js', '/theme/js/{script}', Controllers\Themes\JsController::class],
    ];

    private const array REDIRECTS = [
        ['/page/an-old-page', '/page/a-new-page', 301],
        ['/post/an-old-post', '/post/a-new-post', 301],
    ];

    #[Test]
    public function it_registers_all_application_routes(): void
    {
        $this->container->set('authors_enabled', true);
        $this->container->set('tags_enabled', true);
        $this->container->set('posts_list_enabled', true);
        $this->container->set('redirects_file', 'NONEXISTENT_FILE');

        /** @var App<Container>&MockObject $app */
        $app = $this->mock(App::class);

        $app->expects($matcher = $this->atLeast(1))->method('get')->willReturnCallback(
            function (string $pattern, string $controller) use ($matcher): RouteInterface {
                [$expectedName, $expectedPattern, $expectedController] = self::ROUTES[$matcher->numberOfInvocations() - 1];

                $this->assertSame($expectedPattern, $pattern);
                $this->assertSame($expectedController, $controller);

                $routeMock = $this->mock(RouteInterface::class);
                $routeMock->expects($this->once())->method('setName')->with($expectedName)->willReturnSelf();

                return $routeMock;
            }
        );

        $this->container->call(RouteManager::class);
    }

    #[Test]
    public function it_registers_redirects_from_the_redirects_file(): void
    {
        $this->container->set('redirects_file', $this->filePath('data/redirects.yaml'));

        /** @var App<Container>&MockObject $app */
        $app = $this->mock(App::class);

        $app->expects($matcher = $this->atLeast(1))->method('redirect')->willReturnCallback(
            function (string $from, string $to, int $status) use ($matcher): RouteInterface {
                [$expectedFrom, $expectedTo, $expectedStatus] = self::REDIRECTS[$matcher->numberOfInvocations() - 1];

                $this->assertSame($expectedFrom, $from);
                $this->assertSame($expectedTo, $to);
                $this->assertSame($expectedStatus, $status);

                return $this->createStub(RouteInterface::class);
            }
        );

        $this->container->call(RouteManager::class);
    }

    #[Test]
    public function it_does_not_register_redirects_when_the_redirects_file_does_not_exist(): void
    {
        $this->container->set('redirects_file', 'NONEXISTENT_FILE');

        /** @var App<Container>&MockObject $app */
        $app = $this->mock(App::class);

        $app->expects($this->never())->method('redirect');

        $this->container->call(RouteManager::class);
    }

    #[Test]
    public function it_ignores_missing_redirect_sections(): void
    {
        $this->container->set('redirects_file', $this->filePath('data/redirects-partial.yaml'));

        /** @var App<Container>&MockObject $app */
        $app = $this->mock(App::class);

        $app->expects($this->once())->method('redirect')->with('/page/an-old-page', '/page/a-new-page', 301);

        $this->container->call(RouteManager::class);
    }
}
