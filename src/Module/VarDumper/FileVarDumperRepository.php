<?php

declare(strict_types=1);

namespace App\Debug\Module\VarDumper;

use SleekDB\Store;

final readonly class FileVarDumperRepository implements VarDumperRepository
{
    public function __construct(private Store $store)
    {
    }

    public function save(array $dump): void
    {
        $this->store->insert($dump);
    }

    public function findAll(array $criterias): array
    {
        return $this->store->findAll($criterias);
    }
}