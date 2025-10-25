<?php
error_reporting(1);
ini_set('display_errors', 1);
require_once __DIR__ . '/db.php';
if (!isset($db) || !$db) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}
header('Content-Type: application/json');

// User count
$userCount = $db->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
// Workout count
$workoutCount = $db->query("SELECT COUNT(*) FROM workouts")->fetch_row()[0];
// Feedback count
$feedbackCount = $db->query("SELECT COUNT(*) FROM feedback")->fetch_row()[0];
// Engagement: fallback to user count (or use another metric)
$engagement = $userCount;

// User growth (last 6 months)
$userGrowthLabels = [];
$userGrowthData = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-{$i} months"));
    $userGrowthLabels[] = $month;
    $count = $db->query("SELECT COUNT(*) FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'")->fetch_row()[0];
    $userGrowthData[] = (int)$count;
}

// Workout trends (last 6 months, use created_at)
$workoutTrendLabels = $userGrowthLabels;
$workoutTrendData = [];
for ($i = 5; $i >= 0; $i--) {
    $month = $userGrowthLabels[5 - $i];
    $count = $db->query("SELECT COUNT(*) FROM workouts WHERE DATE_FORMAT(created_at, '%Y-%m') = '$month'")->fetch_row()[0];
    $workoutTrendData[] = (int)$count;
}

echo json_encode([
    'userCount' => (int)$userCount,
    'workoutCount' => (int)$workoutCount,
    'feedbackCount' => (int)$feedbackCount,
    'engagement' => (int)$engagement,
    'userGrowth' => [
        'labels' => $userGrowthLabels,
        'data' => $userGrowthData
    ],
    'workoutTrends' => [
        'labels' => $workoutTrendLabels,
        'data' => $workoutTrendData
    ]
]);
