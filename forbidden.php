<?php
http_response_code(403);
$base = dirname($_SERVER['PHP_SELF']);
define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
$pageTitle = 'Access restricted';
$pageEyebrow = 'Permission required';
$pageSubtitle = 'This area is only available to an authorized account. Sign in with the correct account or return to the student hub.';
$pageStats = [
    ['value' => '403', 'label' => 'access restricted'],
    ['value' => 'Secure', 'label' => 'account area'],
    ['value' => 'Campusly', 'label' => 'student hub'],
];
$pageCards = [
    ['title' => 'Sign in to your account', 'description' => 'Use your student account to access your private student pages.', 'href' => 'login.php', 'label' => 'Sign in'],
    ['title' => 'Return to Campusly', 'description' => 'Go back to the public student hub and explore campus resources.', 'href' => 'index.php', 'label' => 'Go home'],
];
require __DIR__ . '/includes/portal-page.php';
