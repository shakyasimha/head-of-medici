<?php
// db.php 

function loadenv($path)
{
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (stripos(trim($line), '#') === 0) {
            continue;
        }

        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            // Strip optional quotes around values
            $value = preg_replace('/^["\'](.*)["\']$/', '$1', $value);

            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}

// Automatically load the environment variables from your local .env file
loadEnv(__DIR__ . '/.env');

// Proceed to map your credentials exactly as planned
$host    = $_ENV['DB_HOST'];
$port    = $_ENV['DB_PORT'] ?? '6543';
$db      = $_ENV['DB_DATABASE'] ?? 'postgres';
$user    = $_ENV['DB_USERNAME'];
$pass    = $_ENV['DB_PASSWORD'];

$dsn = "pgsql:host=$host;port=$port;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Connection successful!
} catch (\PDOException $e) {
    die("Supabase Connection Error: " . $e->getMessage());
}
