<?php

declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\IndexController;
use App\Data\Post;
use App\Posts;
use App\Utilities\Paginator;
use Carbon\Carbon;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Support\LazyCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Tests\TestCase;

#[CoversClass(IndexController::class)]
class IndexControllerTest extends TestCase
{
    #[Test, TestWith([1]), TestWith([2]), TestWith([3])]
    public function it_returns_the_list_of_posts_for_a_given_page(int $page): void
    {
        $this->container->set('posts_per_page', $perPage = 4);

        $posts = $this->mock(Posts::class);
        $posts->expects($this->once())->method('all')->willReturn(
            $appPosts = $this->createMock(LazyCollection::class)
        );

        $appPosts->expects($this->once())->method('forPage')->with($page, $perPage)->willReturn(
            $postsForPage = LazyCollection::times(4, fn (int $iteration): Post => new Post(
                title: sprintf('Test Post %d', $iteration),
                body: 'Post body...',
                published: Carbon::now()->subDays($iteration),
            ))
        );

        $twig = $this->mock(Twig::class);
        $twig->expects($this->once())->method('render')->with($testResponse = new Response, 'index.twig', [
            'posts' => $postsForPage,
            'paginator' => new Paginator($appPosts, $perPage, $page),
        ])->willReturn(
            $testResponse->withStatus(StatusCodeInterface::STATUS_OK)
        );

        $response = $this->container->call(IndexController::class, [
            'response' => $testResponse,
            'page' => $page,
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }

    #[Test]
    public function it_shows_an_error_page_when_there_are_no_posts(): void
    {
        $posts = $this->mock(Posts::class);
        $posts->expects($this->once())->method('all')->willReturn(new LazyCollection);

        $twig = $this->mock(Twig::class);
        $twig->expects($this->once())->method('render')->with($testResponse = new Response, 'error.twig', [
            'message' => 'No posts found',
        ])->willReturn(
            $testResponse->withStatus(StatusCodeInterface::STATUS_OK)
        );

        $response = $this->container->call(IndexController::class, [
            'response' => $testResponse,
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
