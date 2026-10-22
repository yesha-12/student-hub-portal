<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_name('studenthub');
	session_start();
}

if (empty($_SESSION['user_logged_in']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
	http_response_code(403);
	echo json_encode(['success' => false, 'message' => 'Administrator access is required.']);
	exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
	header('Allow: GET');
	http_response_code(405);
	echo json_encode(['success' => false, 'message' => 'Only GET is supported.']);
	exit;
}

$studentsFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'students.json';
$students = [];
if (is_file($studentsFile)) {
	$storedStudents = json_decode((string) file_get_contents($studentsFile), true);
	if (!is_array($storedStudents)) {
		http_response_code(500);
		echo json_encode(['success' => false, 'message' => 'Student records could not be read.']);
		exit;
	}
	$students = $storedStudents;
}

$search = trim((string) ($_GET['search'] ?? ''));
if ($search !== '') {
	$students = array_values(array_filter($students, static function (array $student) use ($search): bool {
		foreach (['name', 'email', 'studentId'] as $field) {
			if (stripos((string) ($student[$field] ?? ''), $search) !== false) {
				return true;
			}
		}
		return false;
	}));
}

$total = count($students);
$page = max(1, (int) ($_GET['page'] ?? 1));
$perPage = min(100, max(1, (int) ($_GET['per'] ?? 20)));
$students = array_slice($students, ($page - 1) * $perPage, $perPage);
foreach ($students as &$student) {
	unset($student['password']);
}
unset($student);

echo json_encode([
	'success' => true,
	'message' => 'Students retrieved successfully.',
	'timestamp' => date(DATE_ATOM),
	'data' => [
		'students' => $students,
		'pagination' => [
			'total' => $total,
			'page' => $page,
			'per_page' => $perPage,
			'total_pages' => (int) ceil($total / $perPage),
		],
	],
], JSON_UNESCAPED_SLASHES);
