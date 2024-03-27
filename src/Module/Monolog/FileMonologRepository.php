<?php

declare(strict_types=1);

namespace App\Debug\Module\Monolog;

use SleekDB\Store;

final readonly class FileMonologRepository implements MonologRepository
{
    public function __construct(private Store $store)
    {
    }

    public function save(array $log): void
    {
        $this->store->insert($log);
    }

    public function findAll(array $criterias): array
    {
        return $this->store->findAll($criterias);
    }
}