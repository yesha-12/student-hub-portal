<?php
/**
 * API Endpoint: /api/async_students.php
 * Routes: GET /api/async_students.php?search=term&page=1&per=20 - list students with search and pagination
 *         GET /api/async_students.php?student_id=XXX - get student by ID
 */

// Database config
$host = 'localhost';
$db   = 'studenthub_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Helper functions
function respond($success, $message, $status = 200, $data = []) {
    http_response_code($status);
    $response = [
        'success' => $success,
        'message' => $message,
        'timestamp' => date(DATE_ATOM),
    ];
    if (!empty($data)) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}

// Get query parameters
$query = [];
if (!empty($_SERVER['QUERY_STRING'])) {
    parse_str($_SERVER['QUERY_STRING'], $query);
}
$search = $query['search'] ?? '';
$page = ($query['page'] ?? 1);
$per = ($query['per'] ?? 20);
$offset = ($page - 1) * $per;

// Handle routes
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$route = end($uri);

// Get student ID from query
$id = $query['student_id'] ?? null;

// Handle routes
switch ($route) {
    case '':
        // GET /api/async_students.php - list students with search and pagination
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Build query with search
            $where = '';
            $params = [];
            
            if (!empty($search)) {
                $where = ' WHERE name LIKE ? OR email LIKE ? OR student_id LIKE ?';
                $searchParam = "%$search%";
                $params = [$searchParam, $searchParam, $searchParam];
            }
            
            // Count total for pagination
            $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM students $where");
            $countStmt->execute($params);
            $total = $countStmt->fetch()['total'];
            
            // Get paginated results
            $stmt = $pdo->prepare("SELECT student_id, name, email, department, semester, role, status, created_at FROM students $where ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->execute(array_merge($params, [$per, $offset]));
            $students = $stmt->fetchAll();
            
            respond(true, 'Students retrieved successfully', 200, [
                'students' => $students,
                'pagination' => [
                    'total' => $total,
                    'page' => $page,
                    'per_page' => $per,
                    'total_pages' => ceil($total / $per),
                ]
            ]);
        }
        else {
            respond(false, 'Method not allowed', 405);
        }
        break;

    case 'students':
        // GET /api/async_students.php?student_id=XXX - get student by ID
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id) {
            $stmt = $pdo->prepare('SELECT student_id, name, email, department, semester, role, status, last_login, created_at FROM students WHERE student_id = ?');
            $stmt->execute([$id]);
            $student = $stmt->fetch();
            
            if ($student) {
                respond(true, 'Student retrieved successfully', 200, $student);
            } else {
                respond(false, 'Student not found', 404);
            }
        }
        else {
            respond(false, 'Student ID required', 400);
        }
        break;
        
    default:
        respond(false, 'Route not found', 404);
        break;
}