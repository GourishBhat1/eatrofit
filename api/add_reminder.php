<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['user_id'], $data['reminder_text'], $data['reminder_time'], $data['reminder_date'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}
$stmt = $conn->prepare('INSERT INTO reminders (user_id, reminder_text, reminder_time, reminder_date) VALUES (?, ?, ?, ?)');
$stmt->bind_param('isss', $data['user_id'], $data['reminder_text'], $data['reminder_time'], $data['reminder_date']);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'reminder_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
