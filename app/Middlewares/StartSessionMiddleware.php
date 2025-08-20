<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Exceptions\SessionException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSessionMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException('Session has been start already');
        }

        if (headers_sent($fileName, $line)) {
            throw new SessionException('Header send in ' . $fileName . ' line' . $line . ' before start session');
        }

        session_set_cookie_params([
            'secure'   => true,
            'httponly' => true,
            'samesite' => true
        ]);

        session_start();

        $response = $handler->handle($request);

        session_write_close();

        return $response;
    }
}
