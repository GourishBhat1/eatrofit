<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['habit_id'], $data['streak'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}
$stmt = $conn->prepare('UPDATE goals SET streak = ? WHERE id = ?');
$stmt->bind_param('ii', $data['streak'], $data['habit_id']);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
