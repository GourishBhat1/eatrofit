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

// BMI and weight trends
$bmi_trend = [];
$stmt = $conn->prepare('SELECT metric_date, bmi, weight_kg FROM user_health_metrics WHERE user_id = ? ORDER BY metric_date DESC LIMIT 30');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($date, $bmi, $weight);
while ($stmt->fetch()) {
    $bmi_trend[] = ['date' => $date, 'bmi' => $bmi, 'weight' => $weight];
}
$stmt->close();

// Calories consumed vs burned (burned = placeholder)
$stmt = $conn->prepare('SELECT log_date, SUM(calories) FROM nutrition_logs WHERE user_id = ? GROUP BY log_date ORDER BY log_date DESC LIMIT 30');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($log_date, $calories);
$calories_data = [];
while ($stmt->fetch()) {
    $calories_data[] = ['date' => $log_date, 'calories' => $calories, 'burned' => 0];
}
$stmt->close();

$conn->close();
echo json_encode([
    'bmi_trend' => $bmi_trend,
    'calories_data' => $calories_data
]);
