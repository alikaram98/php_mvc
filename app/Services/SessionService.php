<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\SessionInterface;
use App\Exceptions\SessionException;

class SessionService implements SessionInterface
{
    public function start(): void
    {
        if ($this->isActive()) {
            throw new SessionException('Session has been start already');
        }

        if (headers_sent($fileName, $line)) {
            throw new SessionException('Header send in ' . $fileName . ' line' . $line . ' before start session');
        }

        session_set_cookie_params([
            'secure'   => true,
            'httponly' => true,
            'samesite' => true
        ]);

        session_start();
    }

    public function all(): array
    {
        return $_SESSION;
    }

    public function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function clear(): void
    {
        foreach ($_SESSION as $key => $value) {
            if ($key === 'user') {
                continue;
            }

            unset($_SESSION[$key]);
        }
    }

    public function close(): void
    {
        session_write_close();
    }

    public function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function regenerate():void
    {
        session_regenerate_id();
    }
}
