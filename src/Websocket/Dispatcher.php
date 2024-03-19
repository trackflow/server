<?php

declare(strict_types=1);

namespace App\Debug\Websocket;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

final class Dispatcher implements MessageComponentInterface
{
    public function __construct(
        private \SplObjectStorage $clients = new \SplObjectStorage()
    ) {
    }
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    function onClose(ConnectionInterface $conn)
    {
        $conn->close();
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->clients->detach($conn);
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        foreach ($this->clients as $client) {
            if ($conn != $client) {
                $client->send($msg);
            }
        }
    }
}
