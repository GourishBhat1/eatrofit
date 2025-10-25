<?php
use PHPUnit\Framework\TestCase;

class ErrorLogApiTest extends TestCase {
    public function testErrorLogAcceptsPost() {
        $postData = [
            'msg' => 'Test error',
            'url' => 'test.js',
            'line' => 1,
            'col' => 1,
            'error' => 'Stack trace here'
        ];
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($postData)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents('http://localhost/api/error_log.php', false, $context);
        $this->assertJson($response);
    }
}
