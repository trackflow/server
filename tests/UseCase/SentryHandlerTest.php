<?php

declare(strict_types=1);

namespace  App\Debug\Tests\UseCase;

use App\Debug\Module\Sentry\SentryHandler;
use App\Debug\Tests\InMemory\InMemoryPublisher;
use App\Debug\Tests\InMemory\InMemorySentryRepository;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

final class SentryHandlerTest extends TestCase
{
    public function test_persist_and_publish_sentry(): void
    {
        $handler = new SentryHandler(
            $repository = new InMemorySentryRepository(),
            $publisher = new InMemoryPublisher()
        );

        $request = new ServerRequest(
            'POST',
            '/api/project/store',
            ['X-Sentry-Auth' => 'sentry_client=sentry.php'],
        );

        $request = $request->withParsedBody(['message' => 'Sentry error']);
        $handler($request);

        self::assertEquals(
            [
                ['message' => 'Sentry error']
            ],
            $repository->getMemory()
        );

        self::assertEquals(
            [
                'sentry' => [
                    [
                        'message' => 'Sentry error',
                    ]
                ]
            ],
            $publisher->getMemory()
        );
    }

    public function test_nothing_on_invalid_data(): void
    {
        $handler = new SentryHandler(
            $repository = new InMemorySentryRepository(),
            $publisher = new InMemoryPublisher()
        );

        $request = new ServerRequest(
            'POST',
            '/api/project/store',
            ['X-Sentry-Auth' => 'sentry_client=sentry.php'],
        );

        $handler($request);

        self::assertEquals([], $repository->getMemory());
        self::assertEquals([], $publisher->getMemory());
    }
}
