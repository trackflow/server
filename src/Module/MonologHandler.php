<?php

declare(strict_types=1);

namespace App\Debug\Module;

use App\Debug\Websocket\PublisherInterface;
use React\Socket\ConnectionInterface;
use SleekDB\Store;

final readonly class MonologHandler
{
    public function __construct(
        private Store $store,
        private PublisherInterface $publisher
    ) {
    }

    public function __invoke(ConnectionInterface $connection): void
    {
        $connection->on('data', function($data) {
            try {
                $log = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
                $this->store->insert($log);
                $this->publisher->send($log, 'log');
            } catch (\Exception $e) {
                echo $e->getMessage().PHP_EOL;
            }
        });
    }
}
