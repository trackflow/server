<?php

declare(strict_types=1);

namespace App\Debug;

final class Router
{
    public function __construct(private array $routes = [])
    {
    }

    public function all(): array
    {
        return $this->routes;
    }

    public function get(string $path, callable $controller): self
    {
        $this->addRoute('GET', $path, $controller);

        return $this;
    }

    public function post(string $path, callable $controller): self
    {
        $this->addRoute('POST', $path, $controller);

        return $this;
    }

    private function addRoute(string $method, string $path, callable $controller): void
    {
        $this->routes[$method][] = ['path' => $path, 'controller' => $controller];
    }
}
