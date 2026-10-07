<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AccountController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Simple URL routing
if ($path == '/api/accounts' && $method === 'GET') {
    $controller = new AccountController();
    $controller->show();
} else {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}
