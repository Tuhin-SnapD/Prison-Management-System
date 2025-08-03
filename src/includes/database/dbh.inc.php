<?php
/**
 * Database Connection Handler
 * 
 * Centralized database connection using PDO with improved security
 */

// Include configuration
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config/config.php';

// Get database connection
$pdo = getDBConnection();

// Legacy mysqli connection for backward compatibility
$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASS;
$dbname = DB_NAME;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

