<?php
if (!defined('BASE_URL')) {
    $base = dirname($_SERVER['PHP_SELF']);
    define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
}

// Start session
session_start();

// Destroy the session
$_SESSION = array();
session_destroy();

// Clear remember-me cookie
if (isset($_COOKIE['studenthub_'])) {
    setcookie('studenthub_', '', time() - 3600, '/');
}

header('Location: ' . BASE_URL . 'login.php');
exit;