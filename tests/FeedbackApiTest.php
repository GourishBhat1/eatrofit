<?php
use PHPUnit\Framework\TestCase;

class FeedbackApiTest extends TestCase {
    public function testAddFeedback() {
        $postData = [
            'feedback_text' => 'Test Feedback',
            'rating' => 5
        ];
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($postData)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/api/add_feedback.php', false, $context);
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertTrue($data['success']);
    }
}
