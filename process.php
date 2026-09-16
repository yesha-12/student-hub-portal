<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$dataDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'data';

if (!is_dir($dataDirectory) && !mkdir($dataDirectory, 0755, true) && !is_dir($dataDirectory)) {
	respond(false, 'Unable to create the data directory.', 500);
}

$request = json_decode(file_get_contents('php://input'), true);
if (!is_array($request)) {
	$request = $_POST;
}

$action = strtolower(trim((string) ($request['action'] ?? '')));

try {
	switch ($action) {
		case 'register':
			registerStudent($request, $dataDirectory);
			break;
		case 'login':
			loginStudent($request, $dataDirectory);
			break;
		case 'contact':
			saveContactMessage($request, $dataDirectory);
			break;
		default:
			respond(false, 'Unknown action.', 400);
	}
} catch (Throwable $error) {
	respond(false, 'The request could not be completed.', 500);
}

function registerStudent(array $request, string $dataDirectory): void
{
	$student = [
		'name' => clean($request['name'] ?? ''),
		'studentId' => clean($request['studentId'] ?? ''),
		'email' => strtolower(clean($request['email'] ?? '')),
		'department' => clean($request['department'] ?? ''),
		'semester' => clean($request['semester'] ?? ''),
		'contactNumber' => clean($request['contactNumber'] ?? ''),
		'profilePic' => clean($request['profilePic'] ?? ''),
	];
	$password = (string) ($request['password'] ?? '');

	if (in_array('', $student, true) || $password === '') {
		respond(false, 'All student fields are required.', 422);
	}
	if (!filter_var($student['email'], FILTER_VALIDATE_EMAIL)) {
		respond(false, 'Please provide a valid email address.', 422);
	}
	if (strlen($password) < 6) {
		respond(false, 'Password must contain at least 6 characters.', 422);
	}

	$students = readCollection($dataDirectory . DIRECTORY_SEPARATOR . 'students.json');
	foreach ($students as $existingStudent) {
		if ($existingStudent['studentId'] === $student['studentId'] || $existingStudent['email'] === $student['email']) {
			respond(false, 'A student with this ID or email already exists.', 409);
		}
	}

	$student['password'] = password_hash($password, PASSWORD_DEFAULT);
	$student['createdAt'] = date(DATE_ATOM);
	$students[] = $student;
	writeCollection($dataDirectory . DIRECTORY_SEPARATOR . 'students.json', $students);

	unset($student['password']);
	respond(true, 'Student registered successfully.', 201, ['student' => $student]);
}

function loginStudent(array $request, string $dataDirectory): void
{
	$studentId = clean($request['studentId'] ?? '');
	$password = (string) ($request['password'] ?? '');
	$students = readCollection($dataDirectory . DIRECTORY_SEPARATOR . 'students.json');

	foreach ($students as $student) {
		if ($student['studentId'] === $studentId && password_verify($password, $student['password'])) {
			unset($student['password']);
			respond(true, 'Login successful.', 200, ['student' => $student]);
		}
	}

	respond(false, 'Invalid student ID or password.', 401);
}

function saveContactMessage(array $request, string $dataDirectory): void
{
	$message = [
		'name' => clean($request['name'] ?? ''),
		'email' => strtolower(clean($request['email'] ?? '')),
		'message' => clean($request['message'] ?? ''),
		'createdAt' => date(DATE_ATOM),
	];

	if (in_array('', $message, true)) {
		respond(false, 'Name, email, and message are required.', 422);
	}
	if (!filter_var($message['email'], FILTER_VALIDATE_EMAIL)) {
		respond(false, 'Please provide a valid email address.', 422);
	}

	$messagesFile = $dataDirectory . DIRECTORY_SEPARATOR . 'messages.json';
	$messages = readCollection($messagesFile);
	$messages[] = $message;
	writeCollection($messagesFile, $messages);
	respond(true, 'Message sent successfully.', 201);
}

function readCollection(string $file): array
{
	if (!is_file($file)) {
		return [];
	}

	$contents = file_get_contents($file);
	$collection = json_decode($contents ?: '[]', true);
	return is_array($collection) ? $collection : [];
}

function writeCollection(string $file, array $collection): void
{
	$json = json_encode($collection, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	if ($json === false || file_put_contents($file, $json, LOCK_EX) === false) {
		respond(false, 'Unable to save the data.', 500);
	}
}

function clean($value): string
{
	return trim((string) $value);
}

function respond(bool $success, string $message, int $status, array $data = []): void
{
	http_response_code($status);
	echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
	exit;
}
