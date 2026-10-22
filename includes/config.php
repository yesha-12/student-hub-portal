<?php
// Database configuration
$host = 'localhost';
$db   = 'studenthub_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Session configuration
session_name('studenthub');
session_start();

// Session timeout (10 minutes inactive)
if (isset($_SESSION['LAST_ACTIVITY'])) {
    $elapsed = time() - $_SESSION['LAST_ACTIVITY'];
    if ($elapsed > 600) {
        // Destroy session and redirect to login
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }
}
$_SESSION['LAST_ACTIVITY'] = time();

// Base URL detection
if (!defined('BASE_URL')) {
    $base = dirname($_SERVER['PHP_SELF']);
    define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
}

// Debug mode (set to false in production)
define('DEBUG', false);