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

    // Custom method
    public function find(int $id) {
        $query = "SELECT * FROM {$this->table} WHERE id=:id";

        $stmt = $this->model->db->prepare($query);

        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }
}
