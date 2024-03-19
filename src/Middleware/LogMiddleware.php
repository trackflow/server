<?php

declare(strict_types=1);

namespace App\Debug\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final class LogMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        $start = microtime(true);
        /** @var Response $response */
        $response = $next($request);

        echo sprintf(
            "[%s] \"%s %s HTTP/%s\" %s %s\n",
            date(DATE_ATOM),
            $request->getMethod(),
            $request->getUri()->getPath(),
            $request->getProtocolVersion(),
            $response->getStatusCode(),
            round(microtime(true) - $start, 4)
        );

        return $response;
    }
}
