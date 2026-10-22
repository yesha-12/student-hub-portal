<?php
declare(strict_types=1);

$base = dirname(dirname($_SERVER['PHP_SELF']));
define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('studenthub');
    session_start();
}
if (isset($_SESSION['LAST_ACTIVITY']) && time() - (int) $_SESSION['LAST_ACTIVITY'] > 600) {
    session_unset();
    session_destroy();
    header('Location: ' . BASE_URL . 'login.php?expired=1');
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

function require_portal_role(string $role): void
{
    if (empty($_SESSION['user_logged_in'])) {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }
    if (($_SESSION['user_role'] ?? 'student') !== $role) {
        http_response_code(403);
        header('Location: ' . BASE_URL . 'forbidden.php');
        exit;
    }
}
