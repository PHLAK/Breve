<?php

declare(strict_types=1);

namespace Tests\Middlewares;

use App\Middlewares\RegisterGlobalsMiddleware;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;
use Tests\TestCase;

#[CoversClass(RegisterGlobalsMiddleware::class)]
class RegisterGlobalsMiddlewareTest extends TestCase
{
    private Twig $view;

    protected function setUp(): void
    {
        parent::setUp();

        $this->view = $this->container->get(Twig::class);
    }

    public static function configurationProvider(): array
    {
        return [
            [true, true],
            [true, false],
            [false, true],
            [false, false],
        ];
    }

    public static function currentUrlProvider(): array
    {
        return [
            'without port' => ['https', 'breve.example.com', null, '/post/test-post', 'https://breve.example.com/post/test-post'],
            'with standard port' => ['https', 'breve.example.com', 443, '/post/test-post', 'https://breve.example.com/post/test-post'],
            'with custom port' => ['http', 'breve.example.com', 8080, '/post/test-post', 'http://breve.example.com:8080/post/test-post'],
            'without host' => ['https', '', null, '/post/test-post', '/post/test-post'],
        ];
    }

    #[Test, DataProvider('configurationProvider'), AllowMockObjectsWithoutExpectations]
    public function it_sets_the_global_variables(bool $authorsEnabled, bool $tagsEnabled): void
    {
        $this->container->set('authors_enabled', $authorsEnabled);
        $this->container->set('tags_enabled', $tagsEnabled);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getUri')->willReturn($this->createUri('https', 'breve.example.com', null, '/post/test-post'));

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->once())->method('handle')->with($request);

        $this->container->call(RegisterGlobalsMiddleware::class, [
            'request' => $request,
            'handler' => $handler,
        ]);

        $this->assertEquals([
            'authors_enabled' => $authorsEnabled,
            'tags_enabled' => $tagsEnabled,
            'current_url' => 'https://breve.example.com/post/test-post',
        ], $this->view->getEnvironment()->getGlobals());
    }

    #[Test, DataProvider('currentUrlProvider'), AllowMockObjectsWithoutExpectations]
    public function it_builds_the_current_url_from_the_request_uri(
        string $scheme,
        string $host,
        ?int $port,
        string $path,
        string $expected
    ): void {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getUri')->willReturn($this->createUri($scheme, $host, $port, $path));

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->once())->method('handle')->with($request);

        $this->container->call(RegisterGlobalsMiddleware::class, [
            'request' => $request,
            'handler' => $handler,
        ]);

        $this->assertSame($expected, $this->view->getEnvironment()->getGlobals()['current_url']);
    }

    private function createUri(string $scheme, string $host, ?int $port, string $path): UriInterface
    {
        $uri = $this->createMock(UriInterface::class);
        $uri->method('getScheme')->willReturn($scheme);
        $uri->method('getHost')->willReturn($host);
        $uri->method('getPort')->willReturn($port);
        $uri->method('getPath')->willReturn($path);
        $uri->method('getQuery')->willReturn('q=test');

        return $uri;
    }
}
