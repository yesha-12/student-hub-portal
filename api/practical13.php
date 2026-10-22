<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/practical13-data.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
	header('Allow: GET');
	http_response_code(405);
	echo json_encode(['success' => false, 'message' => 'This demo endpoint supports GET only.']);
	exit;
}

echo json_encode([
	'success' => true,
	'message' => 'Practical 13 demo records loaded.',
	'data' => practical13_students(),
], JSON_UNESCAPED_SLASHES);
