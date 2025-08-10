<?php

declare(strict_types=1);

namespace App\DataObjects;

class MailerConfigFormatter
{
    public function __construct(
        public readonly string $driver,
        public readonly string $username,
        public readonly string $password,
        public readonly string $port,
        public readonly string $host,
        public readonly string $encryption,
    ) {}
}
