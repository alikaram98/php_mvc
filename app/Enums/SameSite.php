<?php

declare(strict_types=1);

namespace App\Enums;

enum SameSite: string
{
    case None   = 'none';
    case Strict = 'strict';
    case Lax    = 'lax';
}
