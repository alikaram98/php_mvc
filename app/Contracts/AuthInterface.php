<?php

declare(strict_types=1);

namespace App\Contracts;

interface AuthInterface
{
    public function user();

    public function attemptLogin(array $data): bool;

    public function check(): bool;

    public function logout(): void;
}
