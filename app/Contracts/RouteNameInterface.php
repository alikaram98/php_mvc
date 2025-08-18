<?php

declare(strict_types=1);

namespace App\Contracts;

use Slim\Interfaces\RouteParserInterface;

interface RouteNameInterface
{
    public function routeName(): RouteParserInterface;

    public function getRoute(): void;
}
