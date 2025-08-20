<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Contracts\SessionInterface;
use App\Exceptions\SessionException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSessionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly SessionInterface $session
    ){}
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->session->start();

        $response = $handler->handle($request);

        $this->session->close();

        return $response;
    }
}
