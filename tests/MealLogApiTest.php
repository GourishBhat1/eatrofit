<?php
use PHPUnit\Framework\TestCase;

class MealLogApiTest extends TestCase {
    public function testLogMeal() {
        $postData = [
            'name' => 'Test Meal',
            'calories' => 500
        ];
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($postData)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/api/log_meal.php', false, $context);
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertTrue($data['success']);
    }
}
