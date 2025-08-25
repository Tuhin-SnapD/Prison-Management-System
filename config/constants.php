<?php
/**
 * Application Constants
 * 
 * Defines all constants used throughout the application
 */

// Application paths
if (!defined('SRC_PATH')) define('SRC_PATH', dirname(__DIR__) . '/src');
if (!defined('PUBLIC_PATH')) define('PUBLIC_PATH', dirname(__DIR__) . '/public');
if (!defined('CONFIG_PATH')) define('CONFIG_PATH', dirname(__DIR__) . '/config');

// Application Configuration
if (!defined('APP_NAME')) define('APP_NAME', 'Prison Management System');
if (!defined('APP_VERSION')) define('APP_VERSION', '2.0');
if (!defined('APP_URL')) define('APP_URL', 'http://localhost/Prison-Management-System/public/');

// Error handling
if (!defined('ERROR_LOG_FILE')) define('ERROR_LOG_FILE', dirname(__DIR__) . '/logs/error.log');
if (!defined('DEBUG_MODE')) define('DEBUG_MODE', true); // Set to false in production

// Session configuration
if (!defined('SESSION_TIMEOUT')) define('SESSION_TIMEOUT', 3600); // 1 hour
if (!defined('SESSION_NAME')) define('SESSION_NAME', 'PMS_SESSION');

// File upload limits
if (!defined('UPLOAD_MAX_SIZE')) define('UPLOAD_MAX_SIZE', 5242880); // 5MB
if (!defined('ALLOWED_EXTENSIONS')) define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf']);

// Security
if (!defined('HASH_COST')) define('HASH_COST', 12);
if (!defined('CSRF_TOKEN_NAME')) define('CSRF_TOKEN_NAME', 'pms_csrf_token');

// Pagination
if (!defined('DEFAULT_PER_PAGE')) define('DEFAULT_PER_PAGE', 10);
if (!defined('MAX_PER_PAGE')) define('MAX_PER_PAGE', 100);

// User types
if (!defined('USER_TYPE_ADMIN')) define('USER_TYPE_ADMIN', 'admin');
if (!defined('USER_TYPE_OFFICER')) define('USER_TYPE_OFFICER', 'officer');
if (!defined('USER_TYPE_JAILOR')) define('USER_TYPE_JAILOR', 'jailor');

// Status constants
if (!defined('STATUS_ACTIVE')) define('STATUS_ACTIVE', 'active');
if (!defined('STATUS_INACTIVE')) define('STATUS_INACTIVE', 'inactive');
if (!defined('STATUS_PENDING')) define('STATUS_PENDING', 'pending');
if (!defined('STATUS_COMPLETED')) define('STATUS_COMPLETED', 'completed');

// Crime types
if (!defined('CRIME_TYPE_FELONY')) define('CRIME_TYPE_FELONY', 'felony');
if (!defined('CRIME_TYPE_MISDEMEANOR')) define('CRIME_TYPE_MISDEMEANOR', 'misdemeanor');
if (!defined('CRIME_TYPE_INFRACTION')) define('CRIME_TYPE_INFRACTION', 'infraction');

// Prisoner status
if (!defined('PRISONER_STATUS_INCARCERATED')) define('PRISONER_STATUS_INCARCERATED', 'incarcerated');
if (!defined('PRISONER_STATUS_RELEASED')) define('PRISONER_STATUS_RELEASED', 'released');
if (!defined('PRISONER_STATUS_TRANSFERRED')) define('PRISONER_STATUS_TRANSFERRED', 'transferred');

// Visitor status
if (!defined('VISITOR_STATUS_APPROVED')) define('VISITOR_STATUS_APPROVED', 'approved');
if (!defined('VISITOR_STATUS_PENDING')) define('VISITOR_STATUS_PENDING', 'pending');
if (!defined('VISITOR_STATUS_DENIED')) define('VISITOR_STATUS_DENIED', 'denied');

// Time formats
if (!defined('DATE_FORMAT')) define('DATE_FORMAT', 'Y-m-d');
if (!defined('DATETIME_FORMAT')) define('DATETIME_FORMAT', 'Y-m-d H:i:s');
if (!defined('TIME_FORMAT')) define('TIME_FORMAT', 'H:i:s');

// Validation rules
if (!defined('MIN_PASSWORD_LENGTH')) define('MIN_PASSWORD_LENGTH', 8);
if (!defined('MAX_PASSWORD_LENGTH')) define('MAX_PASSWORD_LENGTH', 255);
if (!defined('MIN_USERNAME_LENGTH')) define('MIN_USERNAME_LENGTH', 3);
if (!defined('MAX_USERNAME_LENGTH')) define('MAX_USERNAME_LENGTH', 50);

// API response codes
if (!defined('API_SUCCESS')) define('API_SUCCESS', 200);
if (!defined('API_CREATED')) define('API_CREATED', 201);
if (!defined('API_BAD_REQUEST')) define('API_BAD_REQUEST', 400);
if (!defined('API_UNAUTHORIZED')) define('API_UNAUTHORIZED', 401);
if (!defined('API_FORBIDDEN')) define('API_FORBIDDEN', 403);
if (!defined('API_NOT_FOUND')) define('API_NOT_FOUND', 404);
if (!defined('API_SERVER_ERROR')) define('API_SERVER_ERROR', 500);

// Cache settings
if (!defined('CACHE_ENABLED')) define('CACHE_ENABLED', false);
if (!defined('CACHE_DURATION')) define('CACHE_DURATION', 3600); // 1 hour

// Email settings
if (!defined('EMAIL_ENABLED')) define('EMAIL_ENABLED', false);
if (!defined('EMAIL_FROM')) define('EMAIL_FROM', 'noreply@prisonmanagement.com');
if (!defined('EMAIL_FROM_NAME')) define('EMAIL_FROM_NAME', 'Prison Management System');

// Notification settings
if (!defined('NOTIFICATION_ENABLED')) define('NOTIFICATION_ENABLED', true);
if (!defined('NOTIFICATION_EMAIL')) define('NOTIFICATION_EMAIL', true);
if (!defined('NOTIFICATION_SMS')) define('NOTIFICATION_SMS', false);

// Backup settings
if (!defined('BACKUP_ENABLED')) define('BACKUP_ENABLED', true);
if (!defined('BACKUP_RETENTION_DAYS')) define('BACKUP_RETENTION_DAYS', 30);
if (!defined('BACKUP_PATH')) define('BACKUP_PATH', dirname(__DIR__) . '/backups');

// Security headers
if (!defined('SECURITY_HEADERS')) define('SECURITY_HEADERS', [
    'X-Frame-Options' => 'DENY',
    'X-Content-Type-Options' => 'nosniff',
    'X-XSS-Protection' => '1; mode=block',
    'Referrer-Policy' => 'strict-origin-when-cross-origin',
    'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com; img-src 'self' data: https:; font-src 'self' https://unpkg.com;"
]);

// Database table names
if (!defined('TABLE_ADMIN')) define('TABLE_ADMIN', 'Admin');
if (!defined('TABLE_OFFICER')) define('TABLE_OFFICER', 'Officer');
if (!defined('TABLE_JAILOR')) define('TABLE_JAILOR', 'Jailor');
if (!defined('TABLE_PRISONER')) define('TABLE_PRISONER', 'Prisoner');
if (!defined('TABLE_VISITOR')) define('TABLE_VISITOR', 'Visitor');
if (!defined('TABLE_CRIME')) define('TABLE_CRIME', 'Crime');
if (!defined('TABLE_IPC')) define('TABLE_IPC', 'IPC');
if (!defined('TABLE_SECTION')) define('TABLE_SECTION', 'Section');

// File paths for assets
if (!defined('CSS_PATH')) define('CSS_PATH', '/assets/css');
if (!defined('JS_PATH')) define('JS_PATH', '/assets/js');
if (!defined('IMG_PATH')) define('IMG_PATH', '/assets/images');
if (!defined('UPLOAD_PATH')) define('UPLOAD_PATH', '/uploads');

// Environment
if (!defined('ENVIRONMENT')) define('ENVIRONMENT', 'development'); // development, staging, production

// Feature flags
if (!defined('FEATURE_LOGGING')) define('FEATURE_LOGGING', true);
if (!defined('FEATURE_AUDIT_TRAIL')) define('FEATURE_AUDIT_TRAIL', true);
if (!defined('FEATURE_BACKUP')) define('FEATURE_BACKUP', true);
if (!defined('FEATURE_EMAIL_NOTIFICATIONS')) define('FEATURE_EMAIL_NOTIFICATIONS', false);
if (!defined('FEATURE_SMS_NOTIFICATIONS')) define('FEATURE_SMS_NOTIFICATIONS', false);
if (!defined('FEATURE_API')) define('FEATURE_API', true);
