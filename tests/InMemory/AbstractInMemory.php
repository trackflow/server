<?php

declare(strict_types=1);

namespace App\Debug\Tests\InMemory;

class AbstractInMemory
{
    public function __construct(protected array $memory = [])
    {
    }

    public function getMemory(): array
    {
        return $this->memory;
    }
}