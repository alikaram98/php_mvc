<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/constants.php';

Dotenv::createImmutable(__DIR__)->load();

return require CONFIG_PATH . 'container/container.php';
