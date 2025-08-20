<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Contracts\AuthInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\PhpRenderer;

class AuthCheckViewMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly PhpRenderer $phpRenderer,
        private readonly AuthInterface $auth
    ) {}
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->phpRenderer->addAttribute('auth', $this->auth);

        return $handler->handle($request); 
    }
}
