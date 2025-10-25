<?php
use PHPUnit\Framework\TestCase;

class HabitsApiTest extends TestCase {
    public function testGetHabitsReturnsJson() {
        $response = file_get_contents('http://localhost/api/get_habits.php');
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertArrayHasKey('habits', $data);
    }

    public function testAddHabit() {
        $postData = [
            'habit_text' => 'Test Habit'
        ];
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($postData)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/api/add_habit.php', false, $context);
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertTrue($data['success']);
    }

    public function testUpdateHabitStreak() {
        $postData = [
            'id' => 1 // Use a valid habit ID for real test
        ];
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($postData)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/api/update_habit_streak.php', false, $context);
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertTrue($data['success']);
    }
}
