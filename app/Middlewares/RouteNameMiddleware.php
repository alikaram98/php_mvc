<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Contracts\RouteNameInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteNameMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly RouteNameInterface $route
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->route->getRoute();

        return $handler->handle($request);
    }
}
