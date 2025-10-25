<?php
// Simple error logger for API
function log_error($message) {
    $logFile = __DIR__ . '/../logs/api_errors.log';
    $entry = date('Y-m-d H:i:s') . " | " . $message . "\n";
    file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
}
