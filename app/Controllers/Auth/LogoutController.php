<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Contracts\AuthInterface;
use App\Contracts\RouteNameInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class LogoutController
{
    public function __construct(
        private readonly PhpRenderer $phpRenderer,
        private readonly RouteNameInterface $router,
        private readonly AuthInterface $auth,
    ) {}

    public function logout(Request $request, Response $response): Response
    {
        $this->auth->logout();

        return $response->withHeader(
            'Location',
            $this->router->routeName()->urlFor('login')
        )->withStatus(302);
    }
}
