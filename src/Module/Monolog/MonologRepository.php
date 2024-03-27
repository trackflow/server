<?php

declare(strict_types=1);

namespace App\Debug\Module\Monolog;

interface MonologRepository
{
    /** @throws \Exception */
    public function save(array $log): void;

    public function findAll(array $criterias): array;
}