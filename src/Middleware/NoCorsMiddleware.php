<?php

declare(strict_types=1);

namespace App\Debug\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final class NoCorsMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        return $response->withHeader('Access-Control-Allow-Origin', '*');
    }
}
