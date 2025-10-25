<?php
use PHPUnit\Framework\TestCase;

class GoalsApiTest extends TestCase {
    public function testGetGoalsReturnsJson() {
        $response = file_get_contents('http://localhost/api/get_goals.php');
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertArrayHasKey('goals', $data);
    }

    public function testAddGoal() {
        $postData = [
            'goal_text' => 'Test Goal'
        ];
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($postData)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/api/add_goal.php', false, $context);
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertTrue($data['success']);
    }
}
