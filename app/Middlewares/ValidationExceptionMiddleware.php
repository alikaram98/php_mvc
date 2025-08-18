<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Exceptions\ValidationException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ValidationException $e) {
            $data               = $request->getParsedBody();

            $filterFields = ['password', 'confirm_password'];

            $data = array_diff_key($data, array_flip($filterFields));

            $_SESSION['errors'] = $e->errors;
            $_SESSION['old'] = $data;

            $response = $this->responseFactory->createResponse();

            $referer = $request->getServerParams()['HTTP_REFERER'];

            return $response
                ->withHeader('Location', $referer)
                ->withStatus($e->getCode());
        }
    }
}
