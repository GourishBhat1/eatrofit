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

// Get user name
$stmt = $conn->prepare('SELECT name FROM users WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();

// Get latest BMI
$stmt = $conn->prepare('SELECT bmi FROM user_health_metrics WHERE user_id = ? ORDER BY metric_date DESC LIMIT 1');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($bmi);
$stmt->fetch();
$stmt->close();

// Get today's steps (placeholder)
$steps = 0; // Replace with actual logic/device sync

// Get today's water intake
$stmt = $conn->prepare('SELECT SUM(amount_ml) FROM water_intake WHERE user_id = ? AND intake_date = CURDATE()');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($water);
$stmt->fetch();
$stmt->close();

// Get today's calories
$stmt = $conn->prepare('SELECT SUM(calories) FROM nutrition_logs WHERE user_id = ? AND log_date = CURDATE()');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($calories);
$stmt->fetch();
$stmt->close();

// BMI trend for chart
$chart_labels = [];
$chart_bmi = [];
$stmt = $conn->prepare('SELECT metric_date, bmi FROM user_health_metrics WHERE user_id = ? ORDER BY metric_date DESC LIMIT 7');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($date, $bmi_val);
while ($stmt->fetch()) {
    $chart_labels[] = $date;
    $chart_bmi[] = $bmi_val;
}
$stmt->close();

$conn->close();

// Output summary
echo json_encode([
    'name' => $name,
    'bmi' => $bmi,
    'steps' => $steps,
    'water' => $water,
    'calories' => $calories,
    'chart_labels' => array_reverse($chart_labels),
    'chart_bmi' => array_reverse($chart_bmi)
]);
