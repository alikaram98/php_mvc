<?php

declare(strict_types=1);

namespace App\Middlewares;

use Dom\HTMLElement;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\PhpRenderer;

class CsrfTokenMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly PhpRenderer $renderer,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $csrf = $this->container->get('csrf');

        $csrfNameKey  = $csrf->getTokenNameKey();
        $csrfValueKey = $csrf->getTokenValueKey();
        $csrfName     = $csrf->getTokenName();
        $csrfValue    = $csrf->getTokenValue();
        $fields       = <<<HTML
            <input type="hidden" name="$csrfNameKey" value="$csrfName" />
            <input type="hidden" name="$csrfValueKey" value="$csrfValue" />
            HTML;

        $csrf = [
            'keys'   => [
                'name'  => $csrfNameKey,
                'value' => $csrfValueKey
            ],
            'name'   => $csrfName,
            'value'  => $csrfValue,
            'fields' => $fields,
        ];

        $this->renderer->addAttribute('csrf', $csrf);

        return $handler->handle($request);
    }
}
