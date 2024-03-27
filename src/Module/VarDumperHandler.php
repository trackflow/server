<?php

declare(strict_types=1);

namespace App\Debug\Module;

use App\Debug\Websocket\PublisherInterface;
use GuzzleHttp\Psr7\BufferStream;
use React\Socket\ConnectionInterface;
use SleekDB\Store;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Cloner\Stub;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

final readonly class VarDumperHandler
{
    public function __construct(
        private Store $store,
        private PublisherInterface $publisher
    ) {
    }

    public function __invoke(ConnectionInterface $connection): void
    {
        echo 'received dump connection...'.PHP_EOL;

        $buffer = new BufferStream();
        $connection->on('data', function($data) use ($buffer) {
            $buffer->write($data);
        });

        $connection->on('end', function() use ($buffer) {
            $data = $this->decode($buffer->getContents());

            if ($data instanceof Data) {
                $dumper = new HtmlDumper();
                $output = '';
                $dumper->dump($data, function($line, int $depth) use (&$output): void {
                    // A negative depth means "end of dump"
                    if ($depth >= 0) {
                        // Adds a two spaces indentation to the line
                        $output .= str_repeat('  ', $depth).$line."\n";
                    }
                });
                $dump = [
                    'body' => $output
                ];
                $this->store->insert($dump);
                $this->publisher->send($dump, 'dump');
            }
        });
    }

    private function decode(string $content): null|Stub|Data
    {
        $decoded = base64_decode($content);

        if (is_string($decoded)) {
            $stamp = unserialize($decoded, ['allowed_class' => [Data::class, Stub::class]]);
            if (isset($stamp[0]) && ($stamp[0] instanceof Data || $stamp instanceof Stub)) {
                return $stamp[0];
            }
        }

        return null;
    }
}
