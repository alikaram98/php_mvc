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

    public function __construct(
        private ContainerInterface $container
    ) {
        $this->model = $container->get($this->model());

        $this->table = $this->model->getTable();
    }

    /**
     * Global methods
     */
    public function all()
    {
        $stmt = $this->model->db->query("SELECT * FROM {$this->table}");

        return $stmt->fetchAll();
    }

    public function exists($field, $value): bool
    {
        $query = "SELECT EXISTS(SELECT 1 FROM {$this->table} WHERE $field=:$field)";

        $stmt = $this->model->db->prepare($query);

        $stmt->execute([$field => $value]);

        return !!$stmt->fetchColumn();
    }

    public function doesntExist($field, $value): bool
    {
        $query = "SELECT NOT EXISTS(SELECT 1 FROM {$this->table} WHERE $field=:$field)";

        $stmt = $this->model->db->prepare($query);

        $stmt->execute([$field => $value]);

        return !!$stmt->fetchColumn();
    }

    public function store(array $data)
    {
        try {
            $fields = array_keys($data);
            $keys   = implode(',', $fields);
            $values = ':' . implode(',:', $fields);

            $stmt = $this->model->db->prepare("INSERT INTO {$this->table}($keys) VALUES ($values)");

            return $stmt->execute($data);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
