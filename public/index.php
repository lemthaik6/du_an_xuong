<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $env = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') === false) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Autoload classes
require_once __DIR__ . '/../vendor/autoload.php';

// Define base path
define('BASE_PATH', __DIR__ . '/../');
define('PUBLIC_PATH', __DIR__);
define('APP_BASE_URL', '/du_an_xuong/public');

// Load routes
require_once BASE_PATH . 'routes/web.php';
