<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\PhpRenderer;

class ValidationErrorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly PhpRenderer $rendere,
        private readonly SessionInterface $session
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->session->has('errors')) {
            $this->rendere->addAttribute('errors', $this->session->get('errors'));
            $this->session->forget('errors');
        }

        return $handler->handle($request);
    }
}
