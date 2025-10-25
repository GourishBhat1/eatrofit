<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

// Habits are tracked as goals with streaks
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['user_id'], $data['goal_text'], $data['target_value'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}
$stmt = $conn->prepare('INSERT INTO goals (user_id, goal_text, target_value, start_date, streak) VALUES (?, ?, ?, CURDATE(), 0)');
$stmt->bind_param('isd', $data['user_id'], $data['goal_text'], $data['target_value']);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'habit_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
