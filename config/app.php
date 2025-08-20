<?php

declare(strict_types=1);

function realBool($value): bool
{
    if ($value === 'false') {
        return false;
    }

    return true;
}

$appName = $_ENV['APP_NAME'] ?? 'php_mvc';

return [
    'app_name'          => $appName,
    'app_version'       => $_ENV['APP_VERSION'] ?? '1',
    'log_directory'     => STORAGE_PATH . 'mvc/mvc.log',
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
        'from_user'  => $_ENV['MAIL_FROM_USER']
    ],
    'connection'        => [
        'pdo' => [
            'driver'   => $_ENV['DB_DRIVER'] ?? 'mysql',
            'dbname'   => $_ENV['DB_DATABASE'],
            'host'     => $_ENV['DB_HOST'],
            'user'     => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset'  => $_ENV['DB_charset'] ?? 'utf8',
            'options'  => [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_EMULATE_PREPARES   => false
            ]
        ]
    ],
    'session'           => [
        'name'     => $appName,
        'sameSite' => 'strict',
        'httponly' => true,
        'secure'   => true
    ],
];
