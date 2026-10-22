<?php
/**
 * Authentication module for StudentHub Portal
 * Handles login, logout, session management, and role verification
 */

// Require config for database connection and BASE_URL
require_once __DIR__ . '/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

// Get current user data
function get_user($pdo) {
    $studentId = $_SESSION['student_id'] ?? null;
    if (!$studentId) {
        return null;
    }
    
    $stmt = $pdo->prepare('SELECT student_id, name, email, department, semester, role, last_login FROM students WHERE student_id = ?');
    $stmt->execute([$studentId]);
    return $stmt->fetch();
}

// Login function
function login($pdo, $studentId, $remember = false) {
    $studentId = trim((string) $studentId);
    
    // Look up student by ID
    $stmt = $pdo->prepare('SELECT student_id, name, email, password, role FROM students WHERE student_id = ?');
    $stmt->execute([$studentId]);
    $user = $stmt->fetch();
    
    if (!$user) {
        return false;
    }
    
    // Password verify is handled on the login form submission side
    // This function just sets the session
    $_SESSION['user_logged_in'] = true;
    $_SESSION['student_id'] = $user['student_id'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    
    // Regenerate session ID to prevent fixation
    session_regenerate_id(true);
    
    return true;
}

// Logout function
function logout() {
    $_SESSION['user_logged_in'] = false;
    session_unset();
    session_destroy();
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

// Require login - redirect if not logged in
function require_login() {
    if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }
}

// Require specific role
function require_role($role) {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== $role) {
        header('Location: ' . BASE_URL . 'forbidden.php');
        exit;
    }
}

// Get session time left
function get_session_time_left() {
    if (!isset($_SESSION['LAST_ACTIVITY'])) {
        return 600; // Full session
    }
    $elapsed = time() - $_SESSION['LAST_ACTIVITY'];
    $remaining = 600 - $elapsed;
    return max(0, $remaining);
}

// Get session time format
function get_session_time_format() {
    $left = get_session_time_left();
    $minutes = floor($left / 60);
    $seconds = $left % 60;
    return sprintf('%02d:%02d', $minutes, $seconds);
}