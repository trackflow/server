<?php

declare(strict_types=1);

namespace App\Debug\Tests\InMemory;

use App\Debug\Websocket\PublisherInterface;

final class InMemoryPublisher extends AbstractInMemory implements PublisherInterface
{
    public function send(array $data, string $channel): void
    {
        if (!isset($this->memory[$channel])) {
            $this->memory[$channel] = [];
        }

        $this->memory[$channel][] = $data;
    }
}