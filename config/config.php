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

// Error Reporting (set to false in production)
if (!defined('DEBUG_MODE')) {
    define('DEBUG_MODE', true);
}

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
?> 