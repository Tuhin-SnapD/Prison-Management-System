<?php
/**
 * Centralized Error Handling System
 * 
 * Provides consistent error logging, display, and management
 */

class ErrorHandler {
    private static $instance = null;
    private $logFile;
    private $displayErrors;
    private $logErrors;

    private function __construct() {
        $this->logFile = defined('ERROR_LOG_FILE') ? ERROR_LOG_FILE : dirname(dirname(dirname(__FILE__))) . '/logs/error.log';
        $this->displayErrors = defined('DEBUG_MODE') ? DEBUG_MODE : false;
        $this->logErrors = true;
        
        // Create logs directory if it doesn't exist
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize error handling
     */
    public function initialize() {
        // Set error reporting
        if ($this->displayErrors) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }

        // Set custom error handler
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleFatalError']);

        // Set error log file
        ini_set('log_errors', 1);
        ini_set('error_log', $this->logFile);
    }

    /**
     * Handle PHP errors
     * 
     * @param int $errno - Error number
     * @param string $errstr - Error string
     * @param string $errfile - File where error occurred
     * @param int $errline - Line where error occurred
     * @return bool
     */
    public function handleError($errno, $errstr, $errfile, $errline) {
        $error = [
            'type' => 'PHP Error',
            'level' => $this->getErrorLevel($errno),
            'message' => $errstr,
            'file' => $errfile,
            'line' => $errline,
            'timestamp' => date('Y-m-d H:i:s'),
            'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
        ];

        $this->logError($error);

        if ($this->displayErrors) {
            $this->displayError($error);
        }

        return true;
    }

    /**
     * Handle exceptions
     * 
     * @param Exception $exception - The exception
     */
    public function handleException($exception) {
        $error = [
            'type' => 'Exception',
            'level' => 'FATAL',
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'timestamp' => date('Y-m-d H:i:s'),
            'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
        ];

        $this->logError($error);

        if ($this->displayErrors) {
            $this->displayError($error);
        } else {
            $this->displayUserFriendlyError();
        }
    }

    /**
     * Handle fatal errors
     */
    public function handleFatalError() {
        $error = error_get_last();
        
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $errorData = [
                'type' => 'Fatal Error',
                'level' => 'FATAL',
                'message' => $error['message'],
                'file' => $error['file'],
                'line' => $error['line'],
                'timestamp' => date('Y-m-d H:i:s'),
                'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
            ];

            $this->logError($errorData);

            if ($this->displayErrors) {
                $this->displayError($errorData);
            } else {
                $this->displayUserFriendlyError();
            }
        }
    }

    /**
     * Log error to file
     * 
     * @param array $error - Error data
     */
    private function logError($error) {
        if (!$this->logErrors) {
            return;
        }

        $logEntry = sprintf(
            "[%s] %s: %s in %s on line %d\nURL: %s\nIP: %s\nUser-Agent: %s\n",
            $error['timestamp'],
            $error['level'],
            $error['message'],
            $error['file'],
            $error['line'],
            $error['url'],
            $error['ip'],
            $error['user_agent']
        );

        if (isset($error['trace'])) {
            $logEntry .= "Stack Trace:\n" . $error['trace'] . "\n";
        }

        $logEntry .= str_repeat('-', 80) . "\n";

        error_log($logEntry, 3, $this->logFile);
    }

    /**
     * Display error for developers
     * 
     * @param array $error - Error data
     */
    private function displayError($error) {
        if (headers_sent()) {
            return;
        }

        http_response_code(500);
        
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Error - ' . htmlspecialchars($error['message']) . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
                .error-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                .error-header { color: #e53e3e; font-size: 24px; margin-bottom: 20px; }
                .error-details { background: #f7fafc; padding: 20px; border-radius: 4px; margin: 20px 0; }
                .error-trace { background: #2d3748; color: #e2e8f0; padding: 20px; border-radius: 4px; font-family: monospace; white-space: pre-wrap; }
                .error-meta { color: #718096; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class="error-container">
                <div class="error-header">' . htmlspecialchars($error['type']) . '</div>
                <div class="error-details">
                    <strong>Message:</strong> ' . htmlspecialchars($error['message']) . '<br>
                    <strong>File:</strong> ' . htmlspecialchars($error['file']) . '<br>
                    <strong>Line:</strong> ' . htmlspecialchars($error['line']) . '<br>
                    <strong>Time:</strong> ' . htmlspecialchars($error['timestamp']) . '
                </div>';

        if (isset($error['trace'])) {
            echo '<div class="error-trace">' . htmlspecialchars($error['trace']) . '</div>';
        }

        echo '<div class="error-meta">
                    <strong>URL:</strong> ' . htmlspecialchars($error['url']) . '<br>
                    <strong>IP:</strong> ' . htmlspecialchars($error['ip']) . '
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Display user-friendly error page
     */
    private function displayUserFriendlyError() {
        if (headers_sent()) {
            return;
        }

        http_response_code(500);
        
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>System Error</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 40px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
                .error-container { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; max-width: 500px; }
                .error-icon { font-size: 64px; color: #e53e3e; margin-bottom: 20px; }
                .error-title { color: #2d3748; font-size: 24px; margin-bottom: 15px; }
                .error-message { color: #718096; margin-bottom: 30px; }
                .error-actions { margin-top: 30px; }
                .btn { display: inline-block; padding: 12px 24px; background: #4299e1; color: white; text-decoration: none; border-radius: 4px; margin: 0 10px; }
                .btn:hover { background: #3182ce; }
            </style>
        </head>
        <body>
            <div class="error-container">
                <div class="error-icon">⚠️</div>
                <div class="error-title">Oops! Something went wrong</div>
                <div class="error-message">
                    We\'re sorry, but something unexpected happened. Our team has been notified and is working to fix the issue.
                </div>
                <div class="error-actions">
                    <a href="?page=home" class="btn">Go Home</a>
                    <a href="javascript:history.back()" class="btn">Go Back</a>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Get error level string
     * 
     * @param int $errno - Error number
     * @return string - Error level
     */
    private function getErrorLevel($errno) {
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
                return 'FATAL';
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
                return 'WARNING';
            case E_NOTICE:
            case E_USER_NOTICE:
                return 'NOTICE';
            case E_USER_ERROR:
                return 'USER_ERROR';
            case E_USER_WARNING:
                return 'USER_WARNING';
            default:
                return 'UNKNOWN';
        }
    }

    /**
     * Log custom error message
     * 
     * @param string $message - Error message
     * @param string $level - Error level
     * @param array $context - Additional context
     */
    public function log($message, $level = 'INFO', $context = []) {
        $error = [
            'type' => 'Custom Log',
            'level' => strtoupper($level),
            'message' => $message,
            'file' => debug_backtrace()[0]['file'] ?? 'Unknown',
            'line' => debug_backtrace()[0]['line'] ?? 0,
            'timestamp' => date('Y-m-d H:i:s'),
            'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'context' => $context
        ];

        $this->logError($error);
    }

    /**
     * Log database error
     * 
     * @param PDOException $exception - Database exception
     */
    public function logDatabaseError($exception) {
        $error = [
            'type' => 'Database Error',
            'level' => 'ERROR',
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'timestamp' => date('Y-m-d H:i:s'),
            'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
        ];

        $this->logError($error);
    }

    /**
     * Log authentication error
     * 
     * @param string $message - Error message
     * @param array $context - Additional context
     */
    public function logAuthError($message, $context = []) {
        $this->log($message, 'AUTH_ERROR', $context);
    }

    /**
     * Log validation error
     * 
     * @param string $message - Error message
     * @param array $errors - Validation errors
     */
    public function logValidationError($message, $errors = []) {
        $this->log($message, 'VALIDATION_ERROR', ['errors' => $errors]);
    }

    /**
     * Get error log file path
     * 
     * @return string - Log file path
     */
    public function getLogFile() {
        return $this->logFile;
    }

    /**
     * Clear error log
     */
    public function clearLog() {
        if (file_exists($this->logFile)) {
            file_put_contents($this->logFile, '');
        }
    }

    /**
     * Get recent errors
     * 
     * @param int $limit - Number of recent errors to return
     * @return array - Recent errors
     */
    public function getRecentErrors($limit = 10) {
        if (!file_exists($this->logFile)) {
            return [];
        }

        $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $errors = [];
        $currentError = [];

        foreach (array_reverse($lines) as $line) {
            if (strpos($line, '[') === 0 && count($currentError) > 0) {
                $errors[] = $currentError;
                $currentError = [];
                
                if (count($errors) >= $limit) {
                    break;
                }
            }
            $currentError[] = $line;
        }

        if (count($currentError) > 0 && count($errors) < $limit) {
            $errors[] = $currentError;
        }

        return array_reverse($errors);
    }
}

// Initialize error handler
ErrorHandler::getInstance()->initialize();
