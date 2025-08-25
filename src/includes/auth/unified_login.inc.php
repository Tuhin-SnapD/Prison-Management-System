<?php
/**
 * Unified Login Handler
 * 
 * Handles login for all user types using the unified Auth class
 */

// Include required files
require_once SRC_PATH . '/includes/auth/Auth.php';
require_once SRC_PATH . '/includes/database/dbh.inc.php';
require_once SRC_PATH . '/includes/utils/ErrorHandler.php';

// Initialize Auth and ErrorHandler
$auth = new Auth($pdo);
$errorHandler = ErrorHandler::getInstance();

// Handle login requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userType = '';
    $username = '';
    $password = '';
    
    // Determine user type and extract credentials
    if (isset($_POST['admin_login-submit'])) {
        $userType = 'admin';
        $username = $_POST['admin_uname'] ?? '';
        $password = $_POST['admin_pwd'] ?? '';
    } elseif (isset($_POST['officer_login-submit'])) {
        $userType = 'officer';
        $username = $_POST['officer_uname'] ?? '';
        $password = $_POST['officer_pwd'] ?? '';
    } elseif (isset($_POST['jailor_login-submit'])) {
        $userType = 'jailor';
        $username = $_POST['jailor_uname'] ?? '';
        $password = $_POST['jailor_pwd'] ?? '';
    }
    
    if ($userType) {
        // Attempt login
        $result = $auth->login($userType, $username, $password);
        
        if ($result['success']) {
            // Log successful login
            $errorHandler->log("Successful login for user: {$username} (Type: {$userType})", 'INFO');
            
            // Redirect to dashboard
            header("Location: " . $result['redirect']);
            exit();
        } else {
            // Log failed login attempt
            $errorHandler->logAuthError("Failed login attempt for user: {$username} (Type: {$userType})", [
                'reason' => $result['message'],
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
            ]);
            
            // Redirect with error
            header("Location: " . $result['redirect']);
            exit();
        }
    } else {
        // Invalid request
        $errorHandler->log("Invalid login request", 'WARNING');
        header("Location: ?page=home");
        exit();
    }
} else {
    // Not a POST request
    header("Location: ?page=home");
    exit();
}
