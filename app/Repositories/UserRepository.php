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
    
    public function storeGetUser(array $data)
    {
        try {
            $fields = array_keys($data);
            $keys   = implode(',', $fields);
            $values = ':' . implode(',:', $fields);

            $stmt = $this->model->db->prepare("INSERT INTO {$this->table}($keys) VALUES ($values)");
            $stmt->execute($data);

            $id = $this->model->db->lastInsertId();

            $stmt = $this->model->db->prepare("SELECT * FROM {$this->table} WHERE id=:id");

            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetch();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
