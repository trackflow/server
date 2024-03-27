<?php

declare(strict_types=1);

namespace App\Debug\Tests\InMemory;

use App\Debug\Module\Monolog\MonologRepository;

final class InMemoryMonologRepository extends AbstractInMemory implements MonologRepository
{
    public function save(array $log): void
    {
        $this->memory[] = $log;
    }

    public function findAll(array $criterias): array
    {
        return $this->memory;
    }
}