<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Route;
use Tests\TestCase;

class RouterTest extends TestCase
{
    public function test_it_can_visit_the_homepage(): void
    {
        $result = $this->app->router->resolve('/', 'get')['action'];

        $response = $this->app->dispatch($result);

        $this->assertStringContainsString('Welcome', $response);
    }

    public function test_it_can_register_a_get_route(): void
    {
        $this->app->router->register(new Route('get', '/users', ['UserController', 'index']));

        $expected = [
            'action' => ['UserController', 'index'],
            'middleware' => [],
        ];

        $this->assertEquals($expected, $this->app->router->routes()['get']['/users']);
    }

    public function test_it_can_register_a_post_route(): void
    {
        $this->app->router->register(new Route('post', '/users', ['UserController', 'index']));

        $expected = [
            'action' => ['UserController', 'index'],
            'middleware' => [],
        ];

        $this->assertEquals($expected, $this->app->router->routes()['post']['/users']);
    }

    public function test_it_throws_a_404_error_when_a_route_is_not_found(): void
    {
        $this->app->dispatch('/not-existing-route');

        $this->assertEquals(404, http_response_code());
    }
}
