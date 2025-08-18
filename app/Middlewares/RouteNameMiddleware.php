<?php

declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Views\PhpRenderer;

class RouteNameMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly App $app,
        private readonly PhpRenderer $renderer
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeParser = $this->app->getRouteCollector()->getRouteParser();

        $this->renderer->addAttribute('router', $routeParser);

        return $handler->handle($request);
    }
}
