<?php

declare(strict_types=1);

namespace App\Core;

class Model
{
    public function __construct(
        public readonly DB $db
    ) {}
}
