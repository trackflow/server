<?php

declare(strict_types=1);

namespace App\Debug\Tests\InMemory;

use App\Debug\Module\VarDumper\VarDumperRepository;

final class InMemoryVarDumpRepository extends AbstractInMemory implements VarDumperRepository
{
    public function save(array $dump): void
    {
        $this->memory[] = $dump;
    }

    public function findAll(array $criterias): array
    {
        return $this->memory;
    }
}