<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ModelInterface;
use Psr\Container\ContainerInterface;

abstract class Repository
{
    protected ModelInterface $model;

    protected string $table;

    abstract public function model(): string;

    public function __construct(private ContainerInterface $container) {
        $this->model = $container->get($this->model());

        $this->table = $this->model->getTable();
    }

    /**
     * Global methods
     */
    public function all() {
        $stmt = $this->model->db->query("SELECT * FROM {$this->table}");

        return $stmt->fetchAll();
    }
}
