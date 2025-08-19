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
}
