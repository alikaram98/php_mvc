<?php

declare(strict_types=1);

namespace App\Core;

use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Enums\UserAuth;
use App\Repositories\UserRepository;

class Auth implements AuthInterface
{
    private $user;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly SessionInterface $session
    ) {}

    public function user(): mixed
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $userId = $this->session->has(keyAuth())
            ? $this->session->get(keyAuth())
            : null;

        if (!$userId) {
            return null;
        }

        $user = $this->userRepository->findByColumn($userId);

        if (!$user) {
            return null;
        }

        $this->user = $user;

        return $user;
    }

    public function attemptLogin(array $data): bool
    {
        $user = $this->userRepository->findByColumn($data['email'], 'email');

        if (!$user) {
            return false;
        }

        if (!password_verify($data['password'], $user->password)) {
            return false;
        }

        $this->session->regenerate();

        $this->session->put(keyAuth(), $user->id);

        return true;
    }

    public function check(): bool
    {
        return $this->user() ? true : false;
    }

    public function guest(): bool
    {
        return $this->user() ? false : true;
    }

    public function logout(): void
    {
        $this->user = null;

        $this->session->forget(keyAuth());
    }
}
