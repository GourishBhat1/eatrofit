<?php
use PHPUnit\Framework\TestCase;

class WorkoutLogApiTest extends TestCase {
    public function testGetWorkoutsReturnsJson() {
        $response = file_get_contents('http://localhost/api/get_workouts.php');
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertArrayHasKey('workouts', $data);
    }

    public function testAddWorkoutLog() {
        $postData = [
            'name' => 'Test Workout',
            'duration' => 30
        ];
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($postData)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/api/add_workout_log.php', false, $context);
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertTrue($data['success']);
    }
}
