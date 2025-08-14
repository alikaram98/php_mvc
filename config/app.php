<?php

declare(strict_types=1);

function realBool($value): bool
{
    if ($value === 'false') {
        return false;
    }

    return true;
}

return [
    'app_name' => $_ENV['APP_NAME'],
    'app_version' => $_ENV['APP_VERSION'] ?? '1',
    'display_error'     => realBool($_ENV['APP_DEBUG']),
    'error_log'         => true,
    'error_log_details' => true,
    'mailer'            => [
        'driver'     => $_ENV['MAIL_DRIVER'],
        'username'   => $_ENV['MAIL_USERNAME'],
        'password'   => $_ENV['MAIL_PASSWORD'],
        'port'       => $_ENV['MAIL_PORT'],
        'host'       => $_ENV['MAIL_HOST'],
        'encryption' => $_ENV['MAIL_ENCRIPTION'],
        'from_user' => $_ENV['MAIL_FROM_USER']
    ]
];
