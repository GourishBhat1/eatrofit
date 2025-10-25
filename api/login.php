<?php
require_once 'db.php';
require_once 'auth.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?');
$stmt->bind_param('s', $data['email']);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 1) {
    $stmt->bind_result($userId, $hash);
    $stmt->fetch();
    if (password_verify($data['password'], $hash)) {
        $token = generateToken($userId);
        echo json_encode(['success' => true, 'token' => $token, 'user_id' => $userId]);
    } else {
        echo json_encode(['error' => 'Invalid credentials']);
    }
} else {
    echo json_encode(['error' => 'User not found']);
}
$stmt->close();
$conn->close();
