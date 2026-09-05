<?php

declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\TagController;
use App\Data\Post;
use App\Posts;
use App\Utilities\Paginator;
use Carbon\Carbon;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Support\LazyCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Tests\TestCase;

#[CoversClass(TagController::class)]
class TagControllerTest extends TestCase
{
    #[Test]
    public function it_returns_a_list_of_posts_for_a_given_tag(): void
    {
        $this->container->set('posts_per_page', $perPage = 10);

        $posts = $this->mock(Posts::class);
        $posts->expects($this->once())->method('withTag')->with('Foo')->willReturn(
            $postsWithTag = $this->createMock(LazyCollection::class)
        );

        $postsWithTag->expects($this->once())->method('forPage')->with(1, $perPage)->willReturn(
            $postsForPage = LazyCollection::times(10, fn (int $iteration): Post => new Post(
                title: sprintf('Test Post %d', $iteration),
                body: 'Post body...',
                published: Carbon::now()->subDays($iteration),
                tags: ['Foo'],
            ))
        );

        $twig = $this->mock(Twig::class);
        $twig->expects($this->once())->method('render')->with($testResponse = new Response, 'index.twig', [
            'posts' => $postsForPage,
            'paginator' => new Paginator($postsWithTag, $perPage, 1),
        ])->willReturn(
            $testResponse->withStatus(StatusCodeInterface::STATUS_OK)
        );

        $response = $this->container->call(TagController::class, [
            'response' => $testResponse,
            'tag' => 'Foo',
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }

    #[Test]
    public function it_shows_an_error_page_when_no_posts_are_found_for_the_tag(): void
    {
        $posts = $this->mock(Posts::class);
        $posts->expects($this->once())->method('withTag')->with('Bar')->willReturn(new LazyCollection);

        $testResponse = (new Response)->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);

        $twig = $this->mock(Twig::class);
        $twig->expects($this->once())->method('render')->with($testResponse, 'error.twig', [
            'message' => 'No posts with tag "Bar"',
        ])->willReturn($testResponse);

        $response = $this->container->call(TagController::class, [
            'response' => $testResponse,
            'tag' => 'Bar',
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(404, $response->getStatusCode());
    }
}
