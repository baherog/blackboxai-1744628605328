<?php
// Error reporting settings
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'asteriskuser');
define('DB_PASS', 'your_password');
define('DB_NAME', 'asteriskcdrdb');

// Site configuration
define('SITE_TITLE', 'Asternic Call Center Stats for Issabel');
define('VERSION', '1.0.0');

// Set connection to false - we'll use demo data
$conn = false;
error_log("Note: Running in demo mode without database connection");

// Session configuration
session_start();

// Time zone setting
date_default_timezone_set('UTC');

// Define common functions
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($conn) {
        $data = mysqli_real_escape_string($conn, $data);
    }
    return $data;
}

// Start timing for page parse calculation
$start_time = microtime(true);
?>
