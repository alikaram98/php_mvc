<?php

declare(strict_types=1);

namespace App\Core;

use App\Services\RequestService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Csrf
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly RequestService $requestService,
    ) {}

    public function failureHandler(): \Closure
    {
        return function (ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
            $response = $this->responseFactory->createResponse();

            if ($this->requestService->isXhr($request)) {
                return $response->withStatus(419);
            }

            $body = $response->getBody();
            $body->write('Failed CSRF check!');
            return $response
                ->withStatus(419)
                ->withHeader('Content-Type', 'text/plain')
                ->withBody($body);
        };
    }
}
