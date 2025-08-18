<?php

declare(strict_types=1);

namespace App\Controllers\Auth;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class RegisterUserController
{
    public function __construct(
        private readonly PhpRenderer $renderer
    ) {}

    public function register(Request $requet, Response $response): Response
    {
        $this->renderer->setLayout('auth/master.php');

        return $this->renderer->render($response, 'auth/register.php', ['title' => 'register page']);
    }
}
