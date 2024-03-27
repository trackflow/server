<?php

declare(strict_types=1);

namespace App\Debug\Module\Monolog;

use App\Debug\Websocket\PublisherInterface;
use React\Socket\ConnectionInterface;

final readonly class MonologHandler
{
    public function __construct(
        private MonologRepository $repository,
        private PublisherInterface $publisher
    ) {
    }

    public function __invoke(ConnectionInterface $connection): void
    {
        $connection->on('data', function($data) {
            try {
                $log = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
                $this->repository->save($log);
                $this->publisher->send($log, 'log');
            } catch (\Exception $e) {
                $this->publisher->send(['message' => 'Error to parse log'], 'error');
                echo $e->getMessage().PHP_EOL;
            }
        });
    }
}
