<?php

declare(strict_types=1);

namespace App\Debug\Module\Smtp;

use SleekDB\Store;

final class FileSmtpRepository implements SmtpRepository
{
    public function __construct(private readonly Store $store)
    {
    }

    public function save(array $data): array
    {
        return $this->store->insert($data);
    }

    public function get(int $id): array
    {
        $row = $this->store->findById($id);

        if (null === $row) {
            throw new \Exception('Smtp not found');
        }

        return $row;
    }

    public function findAll(array $criterias): array
    {
        return $this->store->findAll($criterias);
    }
}
