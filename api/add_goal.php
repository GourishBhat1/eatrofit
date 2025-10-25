<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['user_id'], $data['goal_text'], $data['target_value'], $data['start_date'], $data['end_date'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}
$stmt = $conn->prepare('INSERT INTO goals (user_id, goal_text, target_value, start_date, end_date) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param('isdss', $data['user_id'], $data['goal_text'], $data['target_value'], $data['start_date'], $data['end_date']);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'goal_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
