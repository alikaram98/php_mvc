<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class DashboardController
{
    public function __construct(
        private readonly PhpRenderer $phpRenderer
    ) {}

    public function dashboard(Request $request, Response $response): Response
    {
        return $this->phpRenderer->render($response, 'dashboard.php');
    }
}
