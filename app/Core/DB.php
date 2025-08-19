<?php

declare(strict_types=1);

namespace App\Core;

use App\Contracts\LogInterface;
use App\Services\Log;
use PDO;
use Psr\Log\LoggerInterface;

/**
 * @mixin PDO
 */
class DB
{
    private PDO $pdo;

    public function __construct(
        private readonly Config $config,
        private readonly LoggerInterface $log
    ) {
        try {
            $dbConfig = $config->get('connection.pdo');

            $this->pdo = new PDO(
                "{$dbConfig['driver']}:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}",
                $dbConfig['user'],
                $dbConfig['password'],
                $dbConfig['options']
            );
        } catch (\PDOException $e) {
            $this->log->error($e->getMessage());
        }
    }

    public function __call(string $method, array $args): mixed
    {
        return call_user_func_array([$this->pdo, $method], $args);
    }
}
