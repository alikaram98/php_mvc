<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestService
{
    public function __construct(
        private readonly SessionInterface $session
    ) {}

    public function referer(ServerRequestInterface $request): string
    {
        $referer = $request->getHeader('referer')[0] ?? '';

        if (!$referer) {
            return $this->session->get('previousUrl');
        }

        $requestHost = parse_url($referer, PHP_URL_HOST);

        if ($requestHost !== $request->getUri()->getHost()) {
            return $this->session->get('previousUrl');
        }

        return $referer;
    }
}
