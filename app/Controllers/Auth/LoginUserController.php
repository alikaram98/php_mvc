<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Contracts\AuthInterface;
use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\RouteNameInterface;
use App\Exceptions\ValidationException;
use App\Repositories\UserRepository;
use App\Requests\Auth\LoginRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class LoginUserController
{
    public function __construct(
        private readonly PhpRenderer $renderer,
        private readonly LoggerInterface $log,
        private readonly RequestValidatorFactoryInterface $requestFactory,
        private readonly UserRepository $userRepository,
        private readonly RouteNameInterface $router,
        private readonly AuthInterface $auth,
    ) {}

    public function login(Request $requet, Response $response): Response
    {
        $this->renderer->setLayout('auth/master.php');

        return $this->renderer->render($response, 'auth/login.php', ['title' => 'Login page']);
    }

    public function loginUser(Request $request, Response $response): Response
    {
        $data = $this->requestFactory->make(LoginRequest::class)->verify($request->getParsedBody());

        if (!$this->auth->attemptLogin($data)) {
            throw new ValidationException(['password' => ['Email or Password is incorrect']]);
        }

        return $response->withHeader(
            'Location',
            $this->router->routeName()->urlFor('dashboard')
        )->withStatus(302);
    }
}
