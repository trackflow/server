<?php

declare(strict_types=1);

namespace App\Debug\Module\VarDumper;

interface VarDumperRepository
{
    /** @throws \Exception */
    public function save(array $dump): void;

    public function findAll(array $criterias): array;
}