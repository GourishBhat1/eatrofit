<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['user_id'], $data['workout_id'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$stmt = $conn->prepare('INSERT INTO user_workouts (user_id, workout_id, completed_at, streak) VALUES (?, ?, NOW(), ?)');
$streak = isset($data['streak']) ? intval($data['streak']) : 1;
$stmt->bind_param('iii', $data['user_id'], $data['workout_id'], $streak);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'log_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
