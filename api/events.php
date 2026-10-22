<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/portal-data.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
	header('Allow: GET');
	http_response_code(405);
	echo json_encode(['success' => false, 'message' => 'Only GET is supported for public campus events.']);
	exit;
}

try {
	echo json_encode(['success' => true, 'events' => campusly_events()], JSON_UNESCAPED_SLASHES);
} catch (Throwable $error) {
	http_response_code(500);
	echo json_encode(['success' => false, 'message' => 'Campus events could not be loaded.']);
}
