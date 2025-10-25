<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: text/html');

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id <= 0) {
    echo '<p>Invalid user ID</p>';
    exit;
}
// Get user info
$stmt = $conn->prepare('SELECT name, email FROM users WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();
// Get latest metrics
$stmt = $conn->prepare('SELECT height_cm, weight_kg, bmi FROM user_health_metrics WHERE user_id = ? ORDER BY metric_date DESC LIMIT 1');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($height, $weight, $bmi);
$stmt->fetch();
$stmt->close();
$conn->close();
echo "<h2>Progress Summary for $name</h2>";
echo "<p>Email: $email</p>";
echo "<ul>";
echo "<li>Height: $height cm</li>";
echo "<li>Weight: $weight kg</li>";
echo "<li>BMI: $bmi</li>";
echo "</ul>";
echo "<p>For full analytics, see dashboard and reports.</p>";
