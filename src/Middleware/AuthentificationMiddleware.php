<?php

declare(strict_types=1);

namespace App\Debug\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final readonly class AuthentificationMiddleware
{
    public function __construct(
        private string $username,
        private string $password
    ) {
        echo 'Authentication enabled'.PHP_EOL;
    }
    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        if ($request->getUri()->getPath() === '/logout') {
            unset($_SESSION['authentification']);

            return new Response(StatusCodeInterface::STATUS_FOUND, ['location' => ['/']]);
        }

        if (isset($_SESSION['authentification'])) {
            /** @var Response $response */
            $response = $next($request);
            return $response->withHeader('Authentification', $_SESSION['authentification']);
        }

        if ($request->getUri()->getPath() === '/login' && $request->getMethod() === 'POST') {
            $body = json_decode((string) $request->getBody(), true);

            if (isset($body['username'], $body['password']) && $body['username'] === $this->username && $body['password'] === $this->password) {
                $_SESSION['authentification'] = uniqid("debug", true);

                return new Response(StatusCodeInterface::STATUS_FOUND, ['Access-Control-Allow-Origin' => '*', 'location' => ['/']]);
            }

            return new Response(StatusCodeInterface::STATUS_BAD_REQUEST, ['Access-Control-Allow-Origin' => '*'], 'Invalid credentials');
        }

        return Response::html(file_get_contents(__DIR__.'/../../public/login.html'));
    }
}
