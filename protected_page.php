<?php
$pageMap = [
    'admin' => 'admin/dashboard.php',
    'student' => 'student/dashboard.php',
    'profile' => 'student/profile.php',
    'courses' => 'student/material.php',
    'assignment' => 'student/material.php',
    'attendance' => 'student/dashboard.php',
    'faculty' => 'about.php',
    'faculty-dashboard' => 'admin/dashboard.php',
];
$page = (string) ($_GET['page'] ?? '');
if (!isset($pageMap[$page])) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$base = dirname($_SERVER['PHP_SELF']);
$baseUrl = $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/';
header('Location: ' . $baseUrl . $pageMap[$page], true, 302);
exit;
