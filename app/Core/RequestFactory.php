<?php

declare(strict_types=1);

namespace App\Core;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\RequestValidatorInterface;
use Psr\Container\ContainerInterface;

class RequestFactory implements RequestValidatorFactoryInterface
{
    public function __construct(
        private readonly ContainerInterface $container
    ) {}

    public function make(string $class): RequestValidatorInterface
    {
        return $this->container->get($class);
    }
}
