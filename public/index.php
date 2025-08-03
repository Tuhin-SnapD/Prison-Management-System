<?php
/**
 * Main Entry Point - Prison Management System
 * 
 * This file serves as the main entry point for the application.
 * It handles routing and includes the appropriate controller files.
 */

// Start session
session_start();

// Define base paths
define('BASE_PATH', dirname(__DIR__));
define('SRC_PATH', BASE_PATH . '/src');
define('CONFIG_PATH', BASE_PATH . '/config');
define('PUBLIC_PATH', __DIR__);

// Include database connection
require_once SRC_PATH . '/includes/database/dbh.inc.php';

// Get the requested page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Security: Sanitize the page parameter
$page = preg_replace('/[^a-zA-Z0-9\-_]/', '', $page);

// Function to safely include files
function safeInclude($filePath) {
    if (file_exists($filePath)) {
        include $filePath;
    } else {
        // Log the missing file for debugging
        error_log("Missing file: " . $filePath);
        include SRC_PATH . '/views/components/error.php';
    }
}

// Route to appropriate controller
switch ($page) {
    case 'home':
        safeInclude(SRC_PATH . '/views/components/landing.php');
        break;
    case 'aboutus':
        safeInclude(SRC_PATH . '/views/components/aboutus.php');
        break;
        
    // Admin routes
    case 'admin':
        // Check if user is logged in as admin
        if (!isset($_SESSION['userUidAdmin'])) {
            header("Location: ?page=signin-admin&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/admin/admin.php');
        break;
    case 'signin-admin':
        safeInclude(SRC_PATH . '/views/auth/signin-admin.php');
        break;
    case 'admin-login':
        safeInclude(SRC_PATH . '/includes/auth/admin.login.inc.php');
        break;
        
    // Jailor routes
    case 'jailor':
        // Check if user is logged in as jailor
        if (!isset($_SESSION['userUidJailor'])) {
            header("Location: ?page=signin-jailor&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/jailor/jailor.php');
        break;
    case 'jailor-dashboard':
        // Check if user is logged in as jailor
        if (!isset($_SESSION['userUidJailor'])) {
            header("Location: ?page=signin-jailor&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/jailor/jailor-dashboard.php');
        break;
    case 'jailor-view':
        // Check if user is logged in as jailor
        if (!isset($_SESSION['userUidJailor'])) {
            header("Location: ?page=signin-jailor&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/jailor/jailor_view.php');
        break;
    case 'signin-jailor':
        safeInclude(SRC_PATH . '/views/auth/signin-jailor.php');
        break;
    case 'jailor-login':
        safeInclude(SRC_PATH . '/includes/auth/jailor.login.inc.php');
        break;
        
    // Officer routes
    case 'officer':
        // Check if user is logged in as admin
        if (!isset($_SESSION['userUidAdmin'])) {
            header("Location: ?page=signin-admin&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/officer/officer.php');
        break;
    case 'officer-dashboard':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/officer/officer-dashboard.php');
        break;
    case 'officer-view':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/officer/officer_view.php');
        break;
    case 'crime':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/officer/crime.php');
        break;
    case 'crime-view':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/officer/crime_view.php');
        break;
    case 'ipc-update':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/officer/ipc_update.php');
        break;
    case 'ipc-view':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/officer/ipc_view.php');
        break;
    case 'signin-officer':
        safeInclude(SRC_PATH . '/views/auth/signin-officer.php');
        break;
    case 'officer-login':
        safeInclude(SRC_PATH . '/includes/auth/officer.login.inc.php');
        break;
    case 'successofficer':
        safeInclude(SRC_PATH . '/views/components/successofficer.php');
        break;
    case 'successjailor':
        safeInclude(SRC_PATH . '/views/components/successjailor.php');
        break;
    case 'success_visitor':
        safeInclude(SRC_PATH . '/views/components/success_visitor.php');
        break;
    case 'successcrime_prisoner':
        safeInclude(SRC_PATH . '/views/components/successcrime_prisoner.php');
        break;
    case 'failure':
        safeInclude(SRC_PATH . '/views/components/failure.php');
        break;
        
    // Prisoner routes
    case 'prisoner-view':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/prisoner/prisoner_view.php');
        break;
    case 'prisoner-newsection':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/prisoner/prisoner_newsection.php');
        break;
    case 'prisoner-out':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/prisoner/prisoner_out.php');
        break;
    case 'prisoner-dateout':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/prisoner/prisoner_dateout.php');
        break;
    case 'section-view':
        // Check if user is logged in as officer
        if (!isset($_SESSION['userUidOfficer'])) {
            header("Location: ?page=signin-officer&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/prisoner/section_view.php');
        break;
        
    // Visitor routes
    case 'visitor':
        // Check if user is logged in as admin
        if (!isset($_SESSION['userUidAdmin'])) {
            header("Location: ?page=signin-admin&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/visitor/visitor.php');
        break;
    case 'visitor-view':
        // Check if user is logged in as admin
        if (!isset($_SESSION['userUidAdmin'])) {
            header("Location: ?page=signin-admin&error=unauthorized");
            exit();
        }
        safeInclude(SRC_PATH . '/controllers/visitor/visitor_view.php');
        break;
        
    // Logout route
    case 'logout':
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        safeInclude(SRC_PATH . '/includes/auth/logout.inc.php');
        break;
        
    // Default route
    default:
        safeInclude(SRC_PATH . '/views/components/landing.php');
        break;
}
?> 