<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_name('studenthub');
	session_start();
}

if (empty($_SESSION['user_logged_in']) || empty($_SESSION['student_id'])) {
	http_response_code(401);
	echo json_encode(['success' => false, 'message' => 'Sign in to access student account data.']);
	exit;
}

$studentsFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'students.json';
if (!is_file($studentsFile)) {
	http_response_code(404);
	echo json_encode(['success' => false, 'message' => 'Student account data was not found.']);
	exit;
}

$students = json_decode((string) file_get_contents($studentsFile), true);
if (!is_array($students)) {
	http_response_code(500);
	echo json_encode(['success' => false, 'message' => 'Student account data could not be read.']);
	exit;
}

foreach ($students as $student) {
	if (($student['studentId'] ?? '') === $_SESSION['student_id']) {
		unset($student['password']);
		echo json_encode(['success' => true, 'student' => $student], JSON_UNESCAPED_SLASHES);
		exit;
	}
}

http_response_code(404);
echo json_encode(['success' => false, 'message' => 'Student account data was not found.']);
