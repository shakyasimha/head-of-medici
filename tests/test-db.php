<?php

use App\Database;

try {
    $pdo = Database::getConnection();
    echo "Successfully connected to Supabase Postgresql";
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
