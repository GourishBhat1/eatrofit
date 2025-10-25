<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id <= 0) {
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}
$stmt = $conn->prepare('SELECT id, goal_text, target_value, current_value, start_date, end_date, completed, streak FROM goals WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$goals = [];
while ($row = $result->fetch_assoc()) {
    $goals[] = $row;
}
$stmt->close();
$conn->close();
echo json_encode(['goals' => $goals]);
