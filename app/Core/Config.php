<?php

declare(strict_types=1);

namespace App\Core;

class Config
{
    public function __construct(
        private readonly array $config
    ) {}

    public function get(string $name, mixed $default = null): mixed
    {
        $path  = explode('.', $name);

        $value = $this->config[array_shift($path)];

        if (!isset($value)) {
            return $default;
        }

        foreach($path as $key) {
            if (!isset($value[$key])) {
                return $default;
            }

            $value = $value[$key];
        }

        return $value;
    }
}
