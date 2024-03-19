<?php

declare(strict_types=1);

namespace App\Debug\Websocket;

interface PublisherInterface
{
    public function send(array $data, string $channel): void;
}
