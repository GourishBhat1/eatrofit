<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

function generateToken($userId) {
    return bin2hex(random_bytes(32));
}

function verifyToken($token) {
    // TODO: Implement token verification (DB or cache)
    return true;
}
