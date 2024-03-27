<?php

declare(strict_types=1);

namespace App\Debug\Tests\UseCase;

use App\Debug\Module\Monolog\MonologHandler;
use App\Debug\Tests\InMemory\InMemoryMonologRepository;
use App\Debug\Tests\InMemory\InMemoryPublisher;
use App\Debug\Tests\TraitStubConnection;
use PHPUnit\Framework\TestCase;

final class MonologHandlerTest extends TestCase
{
    use TraitStubConnection;

    public function test_persist_and_publish_log(): void
    {
        $repository = new InMemoryMonologRepository();
        $publisher = new InMemoryPublisher();
        $handler = new MonologHandler($repository, $publisher);

        $connection = $this->getConnection(onData: '{"channel":"error","level":500,"message":"internal error"}');

        $handler($connection);

        self::assertEquals(
            [
                [
                    'channel' => 'error',
                    'level' => 500,
                    'message' => "internal error"
                ]
            ],
            $repository->getMemory()
        );
        self::assertEquals(
            [
                'log' => [
                    [
                        'channel' => 'error',
                        'level' => 500,
                        'message' => "internal error"
                    ]
                ]
            ],
            $publisher->getMemory()
        );
    }

    public function test_publish_error_with_invalid_log(): void
    {
        $repository = new InMemoryMonologRepository();
        $publisher = new InMemoryPublisher();
        $handler = new MonologHandler($repository, $publisher);

        $connection = $this->getConnection(onData: '{"');

        $handler($connection);

        self::assertEquals([], $repository->getMemory());
        self::assertEquals(
            [
               'error' => [
                   [
                       'message' => 'Error to parse log',
                   ]
               ]
            ],
            $publisher->getMemory()
        );
    }
}
