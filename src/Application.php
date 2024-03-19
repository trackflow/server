<?php

declare(strict_types=1);

namespace App\Debug;

use Ratchet\Http\HttpServer as RachetHttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\MessageComponentInterface;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\LoopInterface;
use React\Http\HttpServer;
use React\Socket\SocketServer;

final class Application
{
    public function __construct(
        private readonly string $host,
        private readonly LoopInterface $loop,
        private array $middlewares = []
    ) {
    }

    public function addMiddleware(callable ...$middleware): self
    {
        $this->middlewares = array_merge($this->middlewares, $middleware);

        return $this;
    }

    public function addSocket(string $host, callable $onConnexion): self
    {
        $server = new SocketServer($host, [], $this->loop);
        $server->on('connection', $onConnexion);

        return $this;
    }

    public function addWebsocket(string $host, MessageComponentInterface $component): self
    {
        new IoServer(
            new RachetHttpServer(new WsServer($component)),
            new SocketServer($host),
            $this->loop
        );

        return $this;
    }

    public function run(): void
    {
        $server = new HttpServer($this->loop, ...$this->middlewares);
        $server->listen(new SocketServer($this->host));
        echo "Server running at http://$this->host" . PHP_EOL;

        $this->loop->run();
    }
}
