<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class LoginUserController
{
    public function __construct(
        private readonly PhpRenderer $renderer
    ) {}
    
    public function login(Request $requet, Response $response): Response
    {
        $this->renderer->setLayout('auth/master.php');

        return $this->renderer->render($response, 'auth/login.php', ['title' => 'Login page']);
    }
}
