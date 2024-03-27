<?php

declare(strict_types=1);

namespace App\Debug\Tests;

use PHPUnit\Framework\MockObject\Generator\Generator as MockGenerator;
use PHPUnit\Framework\MockObject\Stub;
use React\Socket\ConnectionInterface;

trait TraitStubConnection
{
    public function getConnection(mixed $onData): ConnectionInterface
    {
        /** @var Stub|ConnectionInterface $connection */
        $connection = (new MockGenerator)->testDouble(
            ConnectionInterface::class,
            true,
            true,
            callOriginalConstructor: false,
            callOriginalClone: false,
            cloneArguments: false,
            allowMockingUnknownTypes: false,
        );

        $connection
            ->method('on')
            ->willReturnCallback(fn($event, $callable) => match($event) {
                'data' => $callable($onData),
                'end' => $callable(),
                'error' => $callable(new \Exception("connection error")),
            });

        return $connection;
    }
}