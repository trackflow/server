<?php

declare(strict_types=1);

namespace App\Debug\Tests\UseCase;

use App\Debug\Module\VarDumper\VarDumperHandler;
use App\Debug\Tests\InMemory\InMemoryPublisher;
use App\Debug\Tests\InMemory\InMemoryVarDumpRepository;
use App\Debug\Tests\TraitStubConnection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Cloner\Data;

final class VarDumpHandlerTest extends TestCase
{
    use TraitStubConnection;

    public function test_persist_and_publish_dump(): void
    {
        $handler = new VarDumperHandler(
            $repository = new InMemoryVarDumpRepository(),
            $publisher = new InMemoryPublisher(),
        );

        $data = serialize([new Data(['foo' => 'bar'])]);
        $handler($this->getConnection(onData: base64_encode($data)));

        self::assertStringStartsWith('<script>',  $repository->getMemory()[0]['body']);
        self::assertStringStartsWith('<script>',  $publisher->getMemory()['dump'][0]['body']);
    }

    public function test_nothing_with_invalide_dump(): void
    {
        $handler = new VarDumperHandler(
            $repository = new InMemoryVarDumpRepository(),
            $publisher = new InMemoryPublisher(),
        );

        $data = serialize(['foo' => 'bar']);
        $handler($this->getConnection(onData: base64_encode($data)));

        self::assertSame([], $repository->getMemory());
        self::assertSame([], $publisher->getMemory());
    }
}
