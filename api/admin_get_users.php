<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$result = $conn->query('SELECT id, name, email, role FROM users');
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
$result->close();
$conn->close();
echo json_encode(['users' => $users]);
