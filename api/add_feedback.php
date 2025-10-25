<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['user_id'], $data['feedback_text'], $data['rating'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}
$stmt = $conn->prepare('INSERT INTO feedback (user_id, feedback_text, rating) VALUES (?, ?, ?)');
$stmt->bind_param('isi', $data['user_id'], $data['feedback_text'], $data['rating']);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'feedback_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
