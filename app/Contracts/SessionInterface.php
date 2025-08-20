<?php

declare(strict_types=1);

namespace App\Contracts;

interface SessionInterface
{
    public function isActive(): bool;
    public function regenerate():void;
    public function start(): void;
    public function close(): void;
    public function all(): array;
    public function put(string $key, mixed $value): void;
    public function get(string $key): mixed;
    public function has(string $key): bool;
    public function forget(string $key): void;
    public function clear(): void;
}
