<?php
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/demo_stats.php');

/**
 * Get call statistics
 * @return array Array containing call statistics
 */
function getCallStats($type = 'realtime', $start_date = null, $end_date = null) {
    switch ($type) {
        case 'realtime':
            return getDemoRealtimeStats();
        case 'hourly':
            return getDemoHourlyStats($start_date);
        case 'daily':
            return getDemoDailyStats($start_date, $end_date);
        case 'monthly':
            return getDemoMonthlyStats($start_date, $end_date);
        case 'yearly':
            return getDemoYearlyStats($start_date, $end_date);
        default:
            return [];
    }
}

/**
 * Format duration in seconds to human readable format
 * @param int $seconds Duration in seconds
 * @return string Formatted duration
 */
function formatDuration($seconds) {
    if ($seconds < 60) {
        return $seconds . "s";
    } elseif ($seconds < 3600) {
        $minutes = floor($seconds / 60);
        $remaining_seconds = $seconds % 60;
        return $minutes . "m " . $remaining_seconds . "s";
    } else {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        return $hours . "h " . $minutes . "m";
    }
}

/**
 * Check if user is logged in
 * @return bool True if user is logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user']);
}

/**
 * Redirect to login page if user is not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

/**
 * Validate user credentials
 * @param string $username Username to validate
 * @param string $password Password to validate
 * @return bool True if credentials are valid, false otherwise
 */
function validateCredentials($username, $password) {
    // For demo purposes, using hardcoded credentials
    // In production, this should check against a secure database
    return ($username === 'demo' && $password === 'demo');
}
?>
