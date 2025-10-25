<?php
// Database connection using config
$config = require __DIR__ . '/../config/config.php';
$db = new mysqli(
    $config['DB_HOST'],
    $config['DB_USER'],
    $config['DB_PASS'],
    $config['DB_NAME']
);
if ($db->connect_error) {
     require_once __DIR__ . '/error_log.php';
     log_error('DB connection failed: ' . $db->connect_error);
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed']));
}
