<?php
// Database configuration
return [
    'DB_HOST' => getenv('DB_HOST') ?: 'localhost',
    'DB_USER' => getenv('DB_USER') ?: 'root',
    'DB_PASS' => getenv('DB_PASS') ?: '',
    'DB_NAME' => getenv('DB_NAME') ?: 'eatrofit',
    'BASE_URL' => getenv('BASE_URL') ?: 'http://localhost/eatrofit/public',
];
