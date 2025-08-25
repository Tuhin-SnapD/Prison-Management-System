<?php
/**
 * Database Connection Handler
 * 
 * Centralized database connection using PDO with improved security
 */

// Get database connection
// Note: config.php is already included in init.php, so getDBConnection() should be available
if (function_exists('getDBConnection')) {
    $pdo = getDBConnection();
} else {
    // Fallback if function doesn't exist (shouldn't happen in normal flow)
    die("Database configuration not loaded. Please ensure init.php is included first.");
}

// The legacy mysqli connection ($conn) has been removed to enforce the use of PDO.
// All database interactions should now use the $pdo object with prepared statements
// to prevent SQL injection vulnerabilities.
?>
