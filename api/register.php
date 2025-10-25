<?php
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$stmt = $conn->prepare('INSERT INTO users (name, email, phone, gender, dob, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)');
$hashed = password_hash($data['password'], PASSWORD_BCRYPT);
$role = 'user';
$stmt->bind_param('sssssss', $data['name'], $data['email'], $data['phone'], $data['gender'], $data['dob'], $hashed, $role);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'user_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$conn->close();
