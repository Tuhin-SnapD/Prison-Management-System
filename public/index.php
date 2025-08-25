<?php
/**
 * Main Entry Point - Prison Management System
 */

// Include the initialization file
require_once dirname(__DIR__) . '/src/includes/init.php';

$router = new Router();

// Routes
$router->get('home', 'views/components/landing.php');
$router->get('aboutus', 'views/components/aboutus.php');

// Auth routes
$router->get('signin-admin', 'views/auth/signin-admin.php');
$router->get('signin-jailor', 'views/auth/signin-jailor.php');
$router->get('signin-officer', 'views/auth/signin-officer.php');
$router->post('unified-login', 'includes/auth/unified_login.inc.php');

// Admin routes
$router->get('admin', 'controllers/admin/admin.php')->auth('admin');

// Jailor routes
$router->get('jailor', 'controllers/jailor/jailor.php')->auth('admin');
$router->get('jailor-dashboard', 'controllers/jailor/jailor-dashboard.php')->auth('jailor');
$router->get('jailor-view', 'controllers/jailor/jailor_view.php')->auth('jailor');

// Officer routes
$router->get('officer', 'controllers/officer/officer.php')->auth('admin');
$router->get('officer-dashboard', 'controllers/officer/officer-dashboard.php')->auth('officer');
$router->get('officer-view', 'controllers/officer/officer_view.php')->auth('officer');
$router->get('crime', 'controllers/officer/crime.php')->auth('officer');
$router->get('crime-view', 'controllers/officer/crime_view.php')->auth('officer');
$router->get('ipc-update', 'controllers/officer/ipc_update.php')->auth('officer');
$router->get('ipc-view', 'controllers/officer/ipc_view.php')->auth('officer');

// Success and failure pages
$router->get('successofficer', 'views/components/successofficer.php');
$router->get('successjailor', 'views/components/successjailor.php');
$router->get('success_visitor', 'views/components/success_visitor.php');
$router->get('successcrime_prisoner', 'views/components/successcrime_prisoner.php');
$router->get('failure', 'views/components/failure.php');

// Prisoner routes
$router->get('prisoner-view', 'controllers/prisoner/prisoner_view.php')->auth('jailor');
$router->get('prisoner-newsection', 'controllers/prisoner/prisoner_newsection.php')->auth('jailor');
$router->get('prisoner-out', 'controllers/prisoner/prisoner_out.php')->auth('officer');
$router->get('prisoner-dateout', 'controllers/prisoner/prisoner_dateout.php')->auth('officer');
$router->get('section-view', 'controllers/prisoner/section_view.php')->auth('jailor');

// Visitor routes
$router->get('visitor', 'controllers/visitor/visitor.php')->auth('admin');
$router->get('visitor-view', 'controllers/visitor/visitor_view.php')->auth('admin');

// Logout
$router->get('logout', 'includes/auth/logout.inc.php');

$router->dispatch();
