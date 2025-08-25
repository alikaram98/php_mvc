<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Contracts\SessionInterface;
use App\Exceptions\ValidationException;
use App\Services\RequestService;
use App\Services\ResponseFormatter;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly SessionInterface $session,
        private readonly RequestService $requestService,
        private readonly ResponseFormatter $responseFormatter,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ValidationException $e) {
            $data = $request->getParsedBody();

            $filterFields = ['password', 'confirm_password'];

            $data = array_diff_key($data, array_flip($filterFields));

            if ($this->requestService->isXhr($request)) {
                return $this
                    ->responseFormatter
                    ->asJson(
                        $this->responseFactory->createResponse(422),
                        ['old' => $data, 'errors' => $e->errors]
                    );
            }

            $this->session->flash('errors', $e->errors);
            $this->session->flash('old', $data);

            $referer = $this->requestService->referer($request);

            return $this->responseFactory->createResponse(302)->withHeader('Location', $referer);
        }
    }
}
