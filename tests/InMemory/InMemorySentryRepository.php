<?php

declare(strict_types=1);

namespace App\Debug\Tests\InMemory;

use App\Debug\Module\Sentry\SentryRepository;

final class InMemorySentryRepository extends AbstractInMemory implements SentryRepository
{
    public function save(array $data): array
    {
        $this->memory[] = $data;

        return $data;
    }

    public function get(int $id): array
    {
        return current($this->memory);
    }

    public function findAll(array $criterias): array
    {
        return $this->memory;
    }
}