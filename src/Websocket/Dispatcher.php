<?php

declare(strict_types=1);

namespace App\Debug\Websocket;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

final readonly class Dispatcher implements MessageComponentInterface
{
    public function __construct(
        private \SplObjectStorage $clients = new \SplObjectStorage()
    ) {
    }
    function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->attach($conn);
    }

    function onClose(ConnectionInterface $conn): void
    {
        $conn->close();
    }

    function onError(ConnectionInterface $conn, \Exception $e): void
    {
        $this->clients->detach($conn);
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg): void
    {
        /** @var ConnectionInterface $client */
        foreach ($this->clients as $client) {
            if ($conn != $client) {
                $client->send((string) $msg);
            }
        }
    }
}
