<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['user_id'], $data['meal_type'], $data['food_name'], $data['calories'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}
$stmt = $conn->prepare('INSERT INTO nutrition_logs (user_id, meal_type, food_name, calories, protein, carbs, fats, log_date) VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE())');
$protein = isset($data['protein']) ? floatval($data['protein']) : 0;
$carbs = isset($data['carbs']) ? floatval($data['carbs']) : 0;
$fats = isset($data['fats']) ? floatval($data['fats']) : 0;
$stmt->bind_param('issiddd', $data['user_id'], $data['meal_type'], $data['food_name'], $data['calories'], $protein, $carbs, $fats);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'log_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
