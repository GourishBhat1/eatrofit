<?php
use PHPUnit\Framework\TestCase;

class RemindersApiTest extends TestCase {
    public function testAddReminder() {
        $postData = [
            'reminder_text' => 'Test Reminder'
        ];
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($postData)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/api/add_reminder.php', false, $context);
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertTrue($data['success']);
    }
}
