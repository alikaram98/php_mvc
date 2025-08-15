<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Core\DB;

/**
 * @property-read DB $db
 */
interface ModelInterface
{
    public function getTable(): string;
}
