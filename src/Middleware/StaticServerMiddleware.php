<?php

namespace App\Debug\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final readonly class StaticServerMiddleware
{
    public function __construct(private string $path)
    {}

    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        $filepath = rtrim($this->path.DIRECTORY_SEPARATOR.$request->getUri()->getPath(), '/');

        if (file_exists($filepath)) {
            $file = new \SplFileInfo($filepath);

            if ($file->isFile() && $file->isReadable()) {
                $contentType = match($file->getExtension()) {
                    'html', 'svg' => 'text/html',
                    'jpg' => 'image/jpg',
                    'png' => 'image/png',
                    'ico' => 'image/x-icon',
                    default => 'text/plain'
                };

                $file->openFile();

                return new Response(
                    StatusCodeInterface::STATUS_OK,
                    ['Content-Type' => $contentType],
                    file_get_contents($filepath)
                );
            }

        }

        return $next($request);
    }
}