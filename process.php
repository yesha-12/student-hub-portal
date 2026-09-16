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
		case 'update':
			updateStudent($request, $dataDirectory);
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

	checkRequiredFields($student, 'All student fields are required.');
	validatePassword($password);
	validateEmail($student['email']);

	$students = readCollection($dataDirectory . DIRECTORY_SEPARATOR . 'students.json');
	foreach ($students as $existingStudent) {
		if ($existingStudent['studentId'] === $student['studentId'] || $existingStudent['email'] === $student['email']) {
			respond(false, 'Student exists.', 409);
		}
	}

	$student['password'] = password_hash($password, PASSWORD_DEFAULT);
	$student['createdAt'] = date(DATE_ATOM);
	$students[] = $student;
	writeCollection($dataDirectory . DIRECTORY_SEPARATOR . 'students.json', $students);

	unset($student['password']);
	respond(true, 'Student registered.', 201, ['student' => $student]);
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

	respond(false, 'Invalid ID or password.', 401);
}

function updateStudent(array $request, string $dataDirectory): void
{
	$studentId = clean($request['studentId'] ?? '');
	$students = readCollection($dataDirectory . DIRECTORY_SEPARATOR . 'students.json');
	$index = -1;

	foreach ($students as $i => $student) {
		if ($student['studentId'] === $studentId) {
			$index = $i;
			break;
		}
	}

	if ($index === -1) {
		respond(false, 'Student not found.', 404);
	}

	$student = $students[$index];
	$student['name'] = clean($request['name'] ?? $student['name']);
	$student['email'] = strtolower(clean($request['email'] ?? $student['email']));
	$student['department'] = clean($request['department'] ?? $student['department']);
	$student['semester'] = clean($request['semester'] ?? $student['semester']);
	$student['contactNumber'] = clean($request['contactNumber'] ?? $student['contactNumber']);
	$student['profilePic'] = clean($request['profilePic'] ?? $student['profilePic'] ?? '');

	$required = [
		'name' => $student['name'],
		'email' => $student['email'],
		'department' => $student['department'],
		'semester' => $student['semester'],
		'contactNumber' => $student['contactNumber'],
	];
	checkRequiredFields($required, 'Fill all fields.');
	validateEmail($student['email']);

	$password = (string) ($request['password'] ?? '');
	if ($password !== '') {
		validatePassword($password);
		$student['password'] = password_hash($password, PASSWORD_DEFAULT);
	}

	foreach ($students as $i => $existingStudent) {
		if ($i !== $index && ($existingStudent['email'] === $student['email'] || $existingStudent['studentId'] === $student['studentId'])) {
			respond(false, 'Student exists.', 409);
		}
	}

	$students[$index] = $student;
	writeCollection($dataDirectory . DIRECTORY_SEPARATOR . 'students.json', $students);

	unset($student['password']);
	respond(true, 'Updated.', 200, ['student' => $student]);
}

function saveContactMessage(array $request, string $dataDirectory): void
{
	$message = [
		'name' => clean($request['name'] ?? ''),
		'email' => strtolower(clean($request['email'] ?? '')),
		'message' => clean($request['message'] ?? ''),
		'createdAt' => date(DATE_ATOM),
	];

	checkRequiredFields([
		'name' => $message['name'],
		'email' => $message['email'],
		'message' => $message['message'],
	], 'Name, email, and message are required.');
	validateEmail($message['email']);

	$messagesFile = $dataDirectory . DIRECTORY_SEPARATOR . 'messages.json';
	$messages = readCollection($messagesFile);
	$messages[] = $message;
	writeCollection($messagesFile, $messages);
	respond(true, 'Message sent.', 201);
}

function checkRequiredFields(array $fields, string $message): void
{
	if (in_array('', $fields, true)) {
		respond(false, $message, 422);
	}
}

function validateEmail(string $email): void
{
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		respond(false, 'Please provide a valid email address.', 422);
	}
}

function validatePassword(string $password): void
{
	if (strlen($password) < 6) {
		respond(false, 'Password must contain at least 6 characters.', 422);
	}
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
