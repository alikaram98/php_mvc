<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RouteNameInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\PhpRenderer;
use Slim\App;

class RouteNamePhpRendererService implements RouteNameInterface
{
    public function __construct(
        public readonly PhpRenderer $renderer,
        private readonly App $app
    ) {}

    public function routeName(): RouteParserInterface
    {
        return $this->app->getRouteCollector()->getRouteParser();
    }

    public function getRoute(): void
    {
        $routeParser = $this->app->getRouteCollector()->getRouteParser();

        $this->renderer->addAttribute('router', $routeParser);
    }
}
