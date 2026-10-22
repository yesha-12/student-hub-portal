<?php
$base = dirname($_SERVER['PHP_SELF']);
define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('studenthub');
    session_start();
}
if (!empty($_SESSION['user_logged_in'])) {
    $destination = ($_SESSION['user_role'] ?? 'student') === 'admin' ? 'admin/dashboard.php' : 'student/dashboard.php';
    header('Location: ' . BASE_URL . $destination);
    exit;
}
$authMode = 'login';
$authTitle = 'Welcome back';
$authSubtitle = 'Sign in to pick up where your campus life left off.';
$authFields = [
    ['name' => 'studentId', 'label' => 'Student ID', 'type' => 'text', 'autocomplete' => 'username', 'placeholder' => 'Enter your student ID', 'required' => true, 'full' => true],
    ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'autocomplete' => 'current-password', 'placeholder' => 'Enter your password', 'required' => true, 'full' => true],
];
require __DIR__ . '/includes/auth-page.php';
