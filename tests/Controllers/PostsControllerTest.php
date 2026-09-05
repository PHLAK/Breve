<?php

declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\PostsController;
use App\Data\Post;
use App\Posts;
use Carbon\Carbon;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Support\LazyCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Tests\TestCase;

#[CoversClass(PostsController::class)]
class PostsControllerTest extends TestCase
{
    #[Test]
    public function it_returns_the_list_of_posts_grouped_by_year(): void
    {
        $posts = [
            'test-post-1' => new Post(
                title: 'Test Post One',
                body: 'Post body...',
                published: Carbon::parse('2026-08-21 12:00:00'),
            ),
            'test-post-2' => new Post(
                title: 'Test Post Two',
                body: 'Post body...',
                published: Carbon::parse('2026-02-02 12:00:00'),
            ),
            'test-post-3' => new Post(
                title: 'Test Post Three',
                body: 'Post body...',
                published: Carbon::parse('2025-12-12 12:00:00'),
            ),
        ];

        $appPosts = $this->mock(Posts::class);
        $appPosts->expects($this->once())->method('all')->willReturn(
            new LazyCollection($posts)
        );

        $twig = $this->mock(Twig::class);
        $twig->expects($this->once())->method('render')->with($testResponse = new Response, 'posts.twig', [
            'posts' => collect($posts)->groupBy(fn (Post $post): int => $post->published->year, true),
            'count' => 3,
        ])->willReturn(
            $testResponse->withStatus(StatusCodeInterface::STATUS_OK)
        );

        $response = $this->container->call(PostsController::class, [
            'response' => $testResponse,
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }

    #[Test]
    public function it_shows_an_error_page_when_there_are_no_posts(): void
    {
        $appPosts = $this->mock(Posts::class);
        $appPosts->expects($this->once())->method('all')->willReturn(new LazyCollection);

        $twig = $this->mock(Twig::class);
        $twig->expects($this->once())->method('render')->with($testResponse = new Response, 'error.twig', [
            'message' => 'No posts found',
        ])->willReturn(
            $testResponse->withStatus(StatusCodeInterface::STATUS_OK)
        );

        $response = $this->container->call(PostsController::class, [
            'response' => $testResponse,
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
