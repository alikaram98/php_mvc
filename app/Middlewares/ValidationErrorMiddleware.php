<?php

declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\PhpRenderer;

class ValidationErrorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly PhpRenderer $rendere
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!empty($_SESSION['errors'])) {
            $this->rendere->addAttribute('errors', $_SESSION['errors']);

            unset($_SESSION['errors']);
        }

        return $handler->handle($request); 
    }
}
