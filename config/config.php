<?php
/**
 * Application Configuration
 * 
 * Central configuration file for the Prison Management System
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'prisondb');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application Configuration
define('APP_NAME', 'Prison Management System');
define('APP_VERSION', '2.0');
define('APP_URL', 'http://localhost/Prison-Management-System/public/');

// Session Configuration
define('SESSION_TIMEOUT', 3600); // 1 hour
define('SESSION_NAME', 'PMS_SESSION');

// File Upload Configuration
define('UPLOAD_MAX_SIZE', 5242880); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf']);

// Security Configuration
define('HASH_COST', 12); // For password hashing
define('CSRF_TOKEN_NAME', 'pms_csrf_token');

// Error Reporting (set to false in production)
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Database connection function
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die("Connection failed: " . $e->getMessage());
        } else {
            die("Database connection failed. Please contact administrator.");
        }
    }
}

// Helper functions
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function generateCSRFToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

function validateCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

function redirect($page) {
    header("Location: " . APP_URL . "?page=" . $page);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('signin-admin');
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['user_role'] !== $role) {
        redirect('home');
    }
}
?> 