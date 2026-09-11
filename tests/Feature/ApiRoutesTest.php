<?php

namespace Tests\Feature;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;
use Tests\TestCase;

class ApiRoutesTest extends TestCase
{
    public function test_api_routes_are_registered_and_public(): void
    {
        $routes = [
            ['name' => 'hotels.index', 'method' => 'GET', 'uri' => '/api/v1/hotels'],
            ['name' => 'room-types.index', 'method' => 'GET', 'uri' => '/api/v1/room-types'],
            ['name' => 'availability.store', 'method' => 'POST', 'uri' => '/api/v1/availability'],
            ['name' => 'bookings.store', 'method' => 'POST', 'uri' => '/api/v1/bookings'],
        ];

        foreach ($routes as $definition) {
            /** @var Route|null $route */
            $route = RouteFacade::getRoutes()->getByName($definition['name']);

            $this->assertNotNull($route);
            $this->assertSame(ltrim($definition['uri'], '/'), $route->uri());
            $this->assertContains($definition['method'], $route->methods());

            if ($definition['method'] === 'POST') {
                $this->postJson($definition['uri'], [])
                    ->assertStatus(501)
                    ->assertJson(['message' => 'Not implemented']);
            }
        }
    }
}
