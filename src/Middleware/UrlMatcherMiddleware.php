<?php

declare(strict_types=1);

namespace App\Debug\Middleware;

use App\Debug\Router;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final readonly class UrlMatcherMiddleware
{
    public function __construct(private Router $router)
    {
    }

    public function __invoke(ServerRequestInterface $request): Response
    {
        foreach ($this->router->all() as $method => $routes) {
            if ($request->getMethod() === $method) {
                foreach ($routes as $route) {
                    if ($route['path'] === $request->getUri()->getPath()) {
                        return $route['controller']($request);
                    }
                }
                foreach ($routes as $route) {
                    $matches = [];
                    if (preg_match("#" . $route['path'] . "#", $request->getUri()->getPath(), $matches) && count($matches) === 2) {
                        $request = $request->withAttribute('id', $matches[1]);

                        return $route['controller']($request);
                    }
                }
            }
        }

        return Response::html("<h1>Page not found</h1>")->withStatus(404);
    }
}
