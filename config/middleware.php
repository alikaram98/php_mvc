<?php

declare(strict_types=1);

use App\Core\Config;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    $config = $container->get(Config::class);

    $app->addErrorMiddleware(
        displayErrorDetails: $config->get('display_error'),
        logErrors: $config->get('error_log'),
        logErrorDetails: $config->get('error_log_details'),
    );
};
