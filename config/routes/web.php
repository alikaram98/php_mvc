<?php

declare(strict_types=1);

use App\Controllers\Admin\DashboardController;
use App\Controllers\Auth\LoginUserController;
use App\Controllers\Auth\LogoutController;
use App\Controllers\Auth\RegisterUserController;
use App\Controllers\HomeController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;

return function (App $app): void {
    $app->get('/', [HomeController::class, 'index'])->setName('home');

    $app->group('', function (RouteCollectorProxy $auth): void {
        $auth->get('/dashboard', [DashboardController::class, 'dashboard'])->setName('dashboard');

        $auth->post('/logout', [LogoutController::class, 'logout'])->setName('logout');
    })->add(AuthMiddleware::class);

    $app->group('', function (RouteCollectorProxy $auth): void {
        $auth->get('/login', [LoginUserController::class, 'login'])->setName('login');
        $auth->get('/register', [RegisterUserController::class, 'register'])->setName('register');

        $auth->post('/login', [LoginUserController::class, 'loginUser'])->setName('login.user');
        $auth->post('/register', [RegisterUserController::class, 'storeUser'])->setName('register.store');
    })->add(GuestMiddleware::class);
};
