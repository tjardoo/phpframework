<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Route;
use App\Router;
use PHPUnit\Framework\TestCase;
use Illuminate\Container\Container;

class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        $this->router = new Router(new Container());
    }

    public function test_there_are_no_routes_by_default()
    {
        $this->assertEmpty($this->router->routes());
    }

    public function test_it_can_register_a_get_route(): void
    {
        $this->router->register(new Route('get', '/users', ['UserController', 'index']));

        $expected = [
            'get' => [
                '/users' => ['UserController', 'index'],
            ],
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_it_can_register_a_post_route(): void
    {
        $this->router->register(new Route('post', '/users', ['UserController', 'update']));

        $expected = [
            'get' => [
                '/users' => ['UserController', 'index'],
            ],
            'post' => [
                '/users' => ['UserController', 'update'],
            ],
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_it_resolves_a_route_from_a_closure(): void
    {
        $this->router->register(new Route('get', '/users', fn () => 'Hello Closure!'));

        $this->assertEquals('Hello Closure!', $this->router->resolve('/users', 'get'));
    }

    public function test_it_resolves_a_route_from_a_controller(): void
    {
        $anonymousUserController = new class () {
            public function index(): string
            {
                return 'Hello Anonymous Class!';
            }
        };

        $this->router->register(new Route('get', '/users', [$anonymousUserController::class, 'index']));

        $this->assertEquals('Hello Anonymous Class!', $this->router->resolve('/users', 'get'));
    }

    public function test_it_resolves_a_route_from_an_invokable_controller(): void
    {
        $anonymousUserController = new class () {
            public function __invoke(): string
            {
                return 'Hello Invokable Class!';
            }
        };

        // TODO the anonymous class is correctly called in Router:143 but not working in this test case
        $this->router->register(new Route('get', '/users', [$anonymousUserController::class, '__invoke']));

        $this->assertEquals('Hello Invokable Class!', $this->router->resolve('/users', 'get'));
    }

    /** @dataProvider routeNotFoundCases */
    public function test_it_throws_a_route_not_found_exception($requestUri, $requestMethod): void
    {
        $this->expectException(RouteNotFoundException::class);

        $this->router->resolve($requestUri, $requestMethod);
    }

    public function routeNotFoundCases(): array
    {
        return [
            ['/invoices', 'get'],
            ['/users/abc', 'post'],
        ];
    }
}
