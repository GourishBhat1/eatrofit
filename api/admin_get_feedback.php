<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$result = $conn->query('SELECT id, user_id, feedback_text, rating, submitted_at FROM feedback');
$feedback = [];
while ($row = $result->fetch_assoc()) {
    $feedback[] = $row;
}
$result->close();
$conn->close();
echo json_encode(['feedback' => $feedback]);
