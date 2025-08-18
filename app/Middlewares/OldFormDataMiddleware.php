<?php

declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\PhpRenderer;

class OldFormDataMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly PhpRenderer $renderer
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!empty($_SESSION['old'])) {
            $this->renderer->addAttribute('old', $_SESSION['old']);

            unset($_SESSION['old']);
        }

        return $handler->handle($request);
    }
}
