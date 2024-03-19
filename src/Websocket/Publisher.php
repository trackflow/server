<?php

declare(strict_types=1);

namespace App\Debug\Websocket;

use function Ratchet\Client\connect;

final readonly class Publisher implements PublisherInterface
{
    public function __construct(private string $host)
    {
    }

    public function send(array $data, string $channel): void
    {
        $stamp = [
            'channel' => $channel,
            'payload' => $data,
        ];

        connect("ws://{$this->host}")->then(
            fn($conn) => $conn->send(json_encode($stamp, JSON_THROW_ON_ERROR)),
            fn ($e) => throw new \RuntimeException("Could not connect: {$e->getMessage()}\n")
        );
    }
}
