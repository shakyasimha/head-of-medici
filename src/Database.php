<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    /**
     * Minimal .env parser
     */
    private static function loadEnv(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim(preg_replace('/^["\'](.*)["\']$/', '$1', trim($value)));

                $_ENV[$name] = $value;
                putenv("{$name}={$value}");
            }
        }
    }

    /**
     * Get single PDO connection instance
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            // Load environment variables from project root
            self::loadEnv(__DIR__ . '/../.env');

            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $port = $_ENV['DB_PORT'] ?? '5432';
            $db   = $_ENV['DB_NAME'] ?? 'postgres';
            $user = $_ENV['DB_USER'] ?? 'postgres';
            $pass = $_ENV['DB_PASS'] ?? '';

            $dsn = "pgsql:host={$host};port={$port};dbname={$db}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Log the real error on the server side instead of showing it to the client
                error_log("Database Connection Error: " . $e->getMessage());
                throw new PDOException("Could not connect to the database.");
            }
        }

        return self::$instance;
    }
}
