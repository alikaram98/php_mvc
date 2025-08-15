<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ModelInterface;
use App\Core\Model;

class User extends Model implements ModelInterface
{
    public function getTable(): string
    {
        return 'users';
    }
}
