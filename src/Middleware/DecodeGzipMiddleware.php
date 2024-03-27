<?php

declare(strict_types=1);

namespace App\Debug\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final class DecodeGzipMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        if ($request->getHeaderLine('content-encoding') === 'gzip') {
            $body = array_map(
                static fn(string $payload) => json_decode($payload, true, 512, JSON_THROW_ON_ERROR),
                \array_filter(\explode("\n", \gzdecode((string) $request->getBody()) ?: ""))
            );

            $request = $request->withParsedBody(count($body) === 1 ? current($body) : $body);
        }

        return $next($request);
    }
}
