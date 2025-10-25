<?php
use PHPUnit\Framework\TestCase;

class AuthApiTest extends TestCase {
    public function testAuthReturnsJson() {
        $response = file_get_contents('http://localhost/api/auth.php');
        $this->assertJson($response);
        $data = json_decode($response, true);
        $this->assertArrayHasKey('authenticated', $data);
    }
}
