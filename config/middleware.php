<?php

declare(strict_types=1);

use App\Core\Config;
use App\Middlewares\AuthCheckViewMiddleware;
use App\Middlewares\CsrfTokenMiddleware;
use App\Middlewares\OldFormDataMiddleware;
use App\Middlewares\RouteNameMiddleware;
use App\Middlewares\StartSessionMiddleware;
use App\Middlewares\ValidationErrorMiddleware;
use App\Middlewares\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Middleware\MethodOverrideMiddleware;

return function (App $app): void {
    $container = $app->getContainer();

    $config = $container->get(Config::class);

    $app->add(MethodOverrideMiddleware::class);
    $app->add(CsrfTokenMiddleware::class);
    $app->add('csrf');
    $app->add(AuthCheckViewMiddleware::class);
    $app->add(OldFormDataMiddleware::class);
    $app->add(RouteNameMiddleware::class);
    $app->add(ValidationErrorMiddleware::class);
    $app->add(ValidationExceptionMiddleware::class);
    $app->add(StartSessionMiddleware::class);
    $app->addBodyParsingMiddleware();

    $app->addErrorMiddleware(
        displayErrorDetails: $config->get('display_error'),
        logErrors: $config->get('error_log'),
        logErrorDetails: $config->get('error_log_details'),
    );
};
