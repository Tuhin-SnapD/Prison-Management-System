<?php
/**
 * Application Initialization
 * 
 * Sets up all required components for the refactored system
 */

// Start session if not already started (must be first, before any output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include configuration files
require_once dirname(dirname(__DIR__)) . '/config/config.php';
require_once dirname(dirname(__DIR__)) . '/config/constants.php';

// Include core classes
require_once SRC_PATH . '/includes/utils/ErrorHandler.php';
require_once SRC_PATH . '/includes/auth/Auth.php';
require_once SRC_PATH . '/includes/utils/Validator.php';
require_once SRC_PATH . '/includes/controllers/BaseController.php';
require_once SRC_PATH . '/Router.php';

// Initialize error handling
ErrorHandler::getInstance()->initialize();

// Set security headers
if (defined('SECURITY_HEADERS')) {
    foreach (SECURITY_HEADERS as $header => $value) {
        header("$header: $value");
    }
}

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Initialize database connection
try {
    $pdo = getDBConnection();
} catch (PDOException $e) {
    ErrorHandler::getInstance()->logDatabaseError($e);
    if (DEBUG_MODE) {
        die("Database connection failed: " . $e->getMessage());
    } else {
        die("Database connection failed. Please contact administrator.");
    }
}

// Initialize Auth class
global $auth;
$auth = new Auth($pdo);

// Check session timeout
if ($auth->isSessionExpired()) {
    $auth->logout();
    if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
        header("Location: ?page=home");
        exit();
    }
} else {
    // Refresh session
    $auth->refreshSession();
}

// Helper functions
if (!function_exists('old')) {
    /**
     * Get old input value
     * 
     * @param string $key - Input key
     * @param mixed $default - Default value
     * @return mixed
     */
    function old($key, $default = '') {
        return $_SESSION['old'][$key] ?? $default;
    }
}

if (!function_exists('error')) {
    /**
     * Get validation error
     * 
     * @param string $key - Error key
     * @return string|null
     */
    function error($key) {
        return $_SESSION['errors'][$key] ?? null;
    }
}

if (!function_exists('has_error')) {
    /**
     * Check if field has error
     * 
     * @param string $key - Error key
     * @return bool
     */
    function has_error($key) {
        return isset($_SESSION['errors'][$key]);
    }
}

if (!function_exists('success')) {
    /**
     * Get success message
     * 
     * @return string|null
     */
    function success() {
        return $_SESSION['success'] ?? null;
    }
}

if (!function_exists('flash')) {
    /**
     * Set flash message
     * 
     * @param string $key - Message key
     * @param string $message - Message content
     */
    function flash($key, $message) {
        $_SESSION[$key] = $message;
    }
}

if (!function_exists('clear_flash')) {
    /**
     * Clear flash messages
     */
    function clear_flash() {
        unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['success']);
    }
}

// Clear flash messages after they've been used
register_shutdown_function('clear_flash');

// CSRF protection
if (!function_exists('csrf_token')) {
    /**
     * Generate CSRF token
     * 
     * @return string
     */
    function csrf_token() {
        return Validator::generateCSRFToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF input field
     * 
     * @return string
     */
    function csrf_field() {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

// Asset helpers
if (!function_exists('asset')) {
    /**
     * Generate asset URL
     * 
     * @param string $path - Asset path
     * @return string
     */
    function asset($path) {
        return APP_URL . 'assets/' . ltrim($path, '/');
    }
}

if (!function_exists('css')) {
    /**
     * Generate CSS asset URL
     * 
     * @param string $file - CSS file name
     * @return string
     */
    function css($file) {
        return asset('css/' . $file);
    }
}

if (!function_exists('js')) {
    /**
     * Generate JavaScript asset URL
     * 
     * @param string $file - JavaScript file name
     * @return string
     */
    function js($file) {
        return asset('js/' . $file);
    }
}

if (!function_exists('img')) {
    /**
     * Generate image asset URL
     * 
     * @param string $file - Image file name
     * @return string
     */
    function img($file) {
        return asset('images/' . $file);
    }
}

// URL helpers
if (!function_exists('url')) {
    /**
     * Generate URL
     * 
     * @param string $page - Page name
     * @param array $params - Query parameters
     * @return string
     */
    function url($page, $params = []) {
        $url = APP_URL . "?page=" . $page;
        if (!empty($params)) {
            $url .= '&' . http_build_query($params);
        }
        return $url;
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to page
     * 
     * @param string $page - Page name
     * @param array $params - Query parameters
     */
    function redirect($page, $params = []) {
        header("Location: " . url($page, $params));
        exit();
    }
}

// Authentication helpers
if (!function_exists('auth')) {
    /**
     * Get Auth instance
     * 
     * @return Auth
     */
    function auth() {
        global $auth;
        return $auth;
    }
}

if (!function_exists('user')) {
    /**
     * Get current user
     * 
     * @return array|null
     */
    function user() {
        global $auth;
        return $auth->getCurrentUser();
    }
}

if (!function_exists('is_logged_in')) {
    /**
     * Check if user is logged in
     * 
     * @param string $userType - Specific user type
     * @return bool
     */
    function is_logged_in($userType = null) {
        global $auth;
        return $auth->isLoggedIn($userType);
    }
}

// Validation helpers
if (!function_exists('validate')) {
    /**
     * Validate data
     * 
     * @param array $data - Data to validate
     * @param array $rules - Validation rules
     * @return array
     */
    function validate($data, $rules) {
        return Validator::validateForm($data, $rules);
    }
}

if (!function_exists('sanitize')) {
    /**
     * Sanitize input
     * 
     * @param mixed $input - Input to sanitize
     * @param string $type - Sanitization type
     * @return mixed
     */
    function sanitize($input, $type = 'string') {
        return Validator::sanitize($input, $type);
    }
}

// Error handling helpers
if (!function_exists('log_error')) {
    /**
     * Log error
     * 
     * @param string $message - Error message
     * @param string $level - Error level
     * @param array $context - Additional context
     */
    function log_error($message, $level = 'ERROR', $context = []) {
        ErrorHandler::getInstance()->log($message, $level, $context);
    }
}

// Database helpers
if (!function_exists('db')) {
    /**
     * Get database connection
     * 
     * @return PDO
     */
    function db() {
        global $pdo;
        return $pdo;
    }
}

// Format helpers
if (!function_exists('format_date')) {
    /**
     * Format date
     * 
     * @param string $date - Date string
     * @param string $format - Output format
     * @return string
     */
    function format_date($date, $format = 'Y-m-d') {
        return date($format, strtotime($date));
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format datetime
     * 
     * @param string $datetime - Datetime string
     * @param string $format - Output format
     * @return string
     */
    function format_datetime($datetime, $format = 'Y-m-d H:i:s') {
        return date($format, strtotime($datetime));
    }
}

// String helpers
if (!function_exists('str_limit')) {
    /**
     * Limit string length
     * 
     * @param string $string - Input string
     * @param int $limit - Character limit
     * @param string $end - Ending characters
     * @return string
     */
    function str_limit($string, $limit = 100, $end = '...') {
        if (strlen($string) <= $limit) {
            return $string;
        }
        return substr($string, 0, $limit) . $end;
    }
}

if (!function_exists('str_random')) {
    /**
     * Generate random string
     * 
     * @param int $length - String length
     * @return string
     */
    function str_random($length = 16) {
        return bin2hex(random_bytes($length / 2));
    }
}

// Array helpers
if (!function_exists('array_get')) {
    /**
     * Get array value with dot notation
     * 
     * @param array $array - Input array
     * @param string $key - Dot notation key
     * @param mixed $default - Default value
     * @return mixed
     */
    function array_get($array, $key, $default = null) {
        $keys = explode('.', $key);
        $value = $array;
        
        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }
        
        return $value;
    }
}

// Debug helpers
if (!function_exists('dd')) {
    /**
     * Dump and die
     * 
     * @param mixed $var - Variable to dump
     */
    function dd($var) {
        if (DEBUG_MODE) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
            exit();
        }
    }
}

if (!function_exists('dump')) {
    /**
     * Dump variable
     * 
     * @param mixed $var - Variable to dump
     */
    function dump($var) {
        if (DEBUG_MODE) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
    }
}
