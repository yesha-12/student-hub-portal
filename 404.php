<?php
http_response_code(404);
$base = dirname($_SERVER['PHP_SELF']);
define('BASE_URL', $base === '/' || $base === '' ? '' : rtrim($base, '/\\') . '/');
$pageTitle = 'We couldn’t find that page';
$pageEyebrow = '404 · Page not found';
$pageSubtitle = 'The page may have moved or the address may be incorrect. Choose a link below to get back to Campusly.';
$pageStats = [
    ['value' => '404', 'label' => 'page not found'],
    ['value' => 'Try', 'label' => 'another link'],
    ['value' => 'Campusly', 'label' => 'student hub'],
];
$pageCards = [
    ['title' => 'Go to the home page', 'description' => 'Return to the Campusly student hub and start again.', 'href' => 'index.php', 'label' => 'Go home'],
    ['title' => 'Browse campus events', 'description' => 'See upcoming activities and discover what is happening.', 'href' => 'events.php', 'label' => 'Explore events'],
    ['title' => 'Contact support', 'description' => 'Let us know if you think a Campusly link is broken.', 'href' => 'contact.php', 'label' => 'Get help'],
];
$pagePrimaryAction = ['href' => 'index.php', 'label' => 'Back to Campusly'];
require __DIR__ . '/includes/portal-page.php';
