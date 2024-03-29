<?php

declare(strict_types=1);

namespace App\Debug\Module\Sentry;

use App\Debug\Websocket\PublisherInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

final readonly class SentryHandler
{
    public function __construct(
        private SentryRepository $repository,
        private PublisherInterface $publisher,
    ) {
    }

    public function __invoke(ServerRequestInterface $request): Response
    {
        if (\str_contains($request->getHeaderLine('X-Sentry-Auth'), 'sentry_client=sentry.php')) {
            $data = $request->getParsedBody();

            if (is_array($data)) {
                $this->repository->save($data);
                $this->publisher->send($data, 'sentry');
            }
        }

        return Response::json(['ok']);
    }
}
