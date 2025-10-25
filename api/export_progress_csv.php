<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="progress_report.csv"');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id <= 0) {
    echo "error,Invalid user ID\n";
    exit;
}
$out = fopen('php://output', 'w');
fputcsv($out, ['Date', 'BMI', 'Weight', 'Calories', 'Water Intake', 'Sleep Hours']);

// Get progress data
$stmt = $conn->prepare('SELECT m.metric_date, m.bmi, m.weight_kg, n.calories, w.amount_ml, s.hours FROM user_health_metrics m LEFT JOIN nutrition_logs n ON m.user_id = n.user_id AND m.metric_date = n.log_date LEFT JOIN water_intake w ON m.user_id = w.user_id AND m.metric_date = w.intake_date LEFT JOIN sleep_logs s ON m.user_id = s.user_id AND m.metric_date = s.sleep_date WHERE m.user_id = ? ORDER BY m.metric_date DESC');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($date, $bmi, $weight, $calories, $water, $sleep);
while ($stmt->fetch()) {
    fputcsv($out, [$date, $bmi, $weight, $calories, $water, $sleep]);
}
$stmt->close();
fclose($out);
$conn->close();
