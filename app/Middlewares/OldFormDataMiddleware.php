<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\PhpRenderer;

class OldFormDataMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly PhpRenderer $renderer,
        private readonly SessionInterface $session
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($old = $this->session->getFlash('old')) {
            $this->renderer->addAttribute('old', $old);
        }

        return $handler->handle($request);
    }
}
