<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    public function model(): string
    {
        return User::class;
    }

    public function storeGetUser(array $data): ?int
    {
        try {
            $fields = array_keys($data);
            $keys   = implode(',', $fields);
            $values = ':' . implode(',:', $fields);

            $stmt = $this->model->db->prepare("INSERT INTO {$this->table}($keys) VALUES ($values)");
            $stmt->execute($data);

            return (int) $this->model->db->lastInsertId();
        } catch (\PDOException $e) {
            $this->log->error($e->getMessage());
        }

        return null;
    }
}
