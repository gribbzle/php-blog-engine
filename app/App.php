<?php

declare(strict_types=1);

namespace App;

class App
{
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $key): string
    {
        return $_ENV[$key] ?? '';
    }
}
