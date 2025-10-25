<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

// Total users
$result = $conn->query('SELECT COUNT(*) FROM users');
$userCount = $result->fetch_row()[0];
$result->close();

// Engagement: total workout logs
$result = $conn->query('SELECT COUNT(*) FROM user_workouts');
$engagement = $result->fetch_row()[0];
$result->close();

// Total workouts
$result = $conn->query('SELECT COUNT(*) FROM workouts');
$workoutCount = $result->fetch_row()[0];
$result->close();

// Total feedback
$result = $conn->query('SELECT COUNT(*) FROM feedback');
$feedbackCount = $result->fetch_row()[0];
$result->close();

$conn->close();

echo json_encode([
    'userCount' => $userCount,
    'engagement' => $engagement,
    'workoutCount' => $workoutCount,
    'feedbackCount' => $feedbackCount
]);
