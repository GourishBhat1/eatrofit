<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$level = isset($_GET['level']) ? $_GET['level'] : null;
if ($level) {
    $stmt = $conn->prepare('SELECT id, name, level, description, duration_min, demo_media FROM workouts WHERE level = ?');
    $stmt->bind_param('s', $level);
} else {
    $stmt = $conn->prepare('SELECT id, name, level, description, duration_min, demo_media FROM workouts');
}
$stmt->execute();
$result = $stmt->get_result();
$workouts = [];
while ($row = $result->fetch_assoc()) {
    $workouts[] = $row;
}
$stmt->close();
$conn->close();
echo json_encode(['workouts' => $workouts]);
