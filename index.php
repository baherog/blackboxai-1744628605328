<?php
require_once('config.php');
require_once('includes/functions.php');

// If user is logged in, redirect to dashboard
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

// Otherwise redirect to login page
header('Location: login.php');
exit();
?>
