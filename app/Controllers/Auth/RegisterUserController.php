<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\RouteNameInterface;
use App\Repositories\UserRepository;
use App\Requests\Auth\RegisterRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

class RegisterUserController
{
    public function __construct(
        private readonly PhpRenderer $renderer,
        private readonly UserRepository $userRepository,
        private readonly RequestValidatorFactoryInterface $requestFactory,
        private readonly RouteNameInterface $router,
        private readonly LoggerInterface $log
    ) {}

    public function register(Request $requet, Response $response): Response
    {
        $this->renderer->setLayout('auth/master.php');

        return $this->renderer->render(
            $response,
            'auth/register.php',
            ['title' => 'register page']
        );
    }

    public function storeUser(Request $request, Response $response): Response
    {
        $data = $this
            ->requestFactory
            ->make(RegisterRequest::class)
            ->verify($request->getParsedBody());

        $user = $this->userRepository->storeGetUser($data);

        session_regenerate_id();

        $_SESSION['user'] = $user;

        return $response->withHeader(
            'Location',
            $this->router->routeName()->urlFor('dashboard')
        )->withStatus(302);
    }
}
