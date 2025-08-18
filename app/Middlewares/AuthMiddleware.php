<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Contracts\RouteNameInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly RouteNameInterface $route
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!empty($_SESSION['user'])) {
            return $handler->handle($request);
        }

        return $this
            ->responseFactory
            ->createResponse(302)
            ->withHeader(
                'Location',
                $this->route->routeName()->urlFor('home')
             );
    }
}
