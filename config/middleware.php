<?php

declare(strict_types=1);

use App\Core\Config;
use App\Middlewares\StartSessionMiddleware;
use App\Middlewares\ValidationExceptionMiddleware;
use Slim\App;

return function (App $app): void {
    $container = $app->getContainer();

    $config = $container->get(Config::class);

    $app->add(ValidationExceptionMiddleware::class);
    $app->add(StartSessionMiddleware::class);

    $app->addErrorMiddleware(
        displayErrorDetails: $config->get('display_error'),
        logErrors: $config->get('error_log'),
        logErrorDetails: $config->get('error_log_details'),
    );
};
