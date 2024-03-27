<?php

declare(strict_types=1);

namespace App\Debug\Module\Smtp;

interface SmtpRepository
{
    /** @throws \Exception */
    public function save(array $data): array;

    /** @throws \Exception */
    public function get(int $id): array;

    public function findAll(array $criterias): array;
}
