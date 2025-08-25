<?php
/**
 * Unified Authentication Class
 * 
 * Handles authentication for all user types (Admin, Officer, Jailor)
 * Provides centralized login, logout, and session management
 */

class Auth {
    private $pdo;
    private $userTypes = [
        'admin' => [
            'table' => 'Admin',
            'username_field' => 'Admin_uname',
            'password_field' => 'Admin_pwd',
            'session_key' => 'userUidAdmin',
            'dashboard_page' => 'admin'
        ],
        'officer' => [
            'table' => 'Officer',
            'username_field' => 'Officer_uname',
            'password_field' => 'Officer_pwd',
            'session_key' => 'userUidOfficer',
            'dashboard_page' => 'officer-dashboard'
        ],
        'jailor' => [
            'table' => 'Jailor',
            'username_field' => 'Jailor_uname',
            'password_field' => 'Jailor_pwd',
            'session_key' => 'userUidJailor',
            'dashboard_page' => 'jailor-dashboard'
        ]
    ];

    public function __construct($pdo) {
        $this->pdo = $pdo;
        // Only start session if not already started and no output has been sent
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
    }

    /**
     * Authenticate user login
     * 
     * @param string $userType - Type of user (admin, officer, jailor)
     * @param string $username - Username
     * @param string $password - Password
     * @return array - Result with success status and message
     */
    public function login($userType, $username, $password) {
        // Validate user type
        if (!isset($this->userTypes[$userType])) {
            return [
                'success' => false,
                'message' => 'Invalid user type',
                'redirect' => "?page=signin-{$userType}&error=invalidtype"
            ];
        }

        $config = $this->userTypes[$userType];

        // Validate input
        if (empty($username) || empty($password)) {
            return [
                'success' => false,
                'message' => 'Empty fields',
                'redirect' => "?page=signin-{$userType}&error=emptyFields"
            ];
        }

        try {
            // Query user from database
            $sql = "SELECT {$config['username_field']}, {$config['password_field']} 
                    FROM {$config['table']} 
                    WHERE {$config['username_field']} = :username";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch();

            // Verify password - handle both hashed and plain text passwords
            if ($user) {
                $storedPassword = $user[$config['password_field']];
                $passwordValid = false;
                
                // First try password_verify for hashed passwords
                if (password_verify($password, $storedPassword)) {
                    $passwordValid = true;
                }
                // If that fails, check if it's a plain text match (for backward compatibility)
                elseif ($password === $storedPassword) {
                    $passwordValid = true;
                }
                
                if ($passwordValid) {
                    // Set session
                    $_SESSION[$config['session_key']] = $user[$config['username_field']];
                    $_SESSION['user_role'] = $userType;
                    $_SESSION['user_id'] = $user[$config['username_field']];
                    $_SESSION['login_time'] = time();

                    return [
                        'success' => true,
                        'message' => 'Login successful',
                        'redirect' => "?page={$config['dashboard_page']}&login=success"
                    ];
                }
            }
            
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'redirect' => "?page=signin-{$userType}&error=wrongcredentials"
            ];
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error',
                'redirect' => "?page=signin-{$userType}&error=dberror"
            ];
        }
    }

    /**
     * Logout user
     * 
     * @param string $userType - Type of user to logout
     * @return array - Result with success status and redirect
     */
    public function logout($userType = null) {
        if ($userType && isset($this->userTypes[$userType])) {
            $config = $this->userTypes[$userType];
            unset($_SESSION[$config['session_key']]);
        } else {
            // Logout all user types
            foreach ($this->userTypes as $config) {
                unset($_SESSION[$config['session_key']]);
            }
        }

        // Clear all session data
        unset($_SESSION['user_role']);
        unset($_SESSION['user_id']);
        unset($_SESSION['login_time']);
        
        session_destroy();

        return [
            'success' => true,
            'message' => 'Logout successful',
            'redirect' => '?page=home'
        ];
    }

    /**
     * Check if user is logged in
     * 
     * @param string $userType - Specific user type to check (optional)
     * @return bool
     */
    public function isLoggedIn($userType = null) {
        if ($userType) {
            if (!isset($this->userTypes[$userType])) {
                return false;
            }
            $config = $this->userTypes[$userType];
            return isset($_SESSION[$config['session_key']]);
        }

        // Check if any user type is logged in
        foreach ($this->userTypes as $config) {
            if (isset($_SESSION[$config['session_key']])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get current user information
     * 
     * @return array|null - User info or null if not logged in
     */
    public function getCurrentUser() {
        foreach ($this->userTypes as $userType => $config) {
            if (isset($_SESSION[$config['session_key']])) {
                return [
                    'type' => $userType,
                    'username' => $_SESSION[$config['session_key']],
                    'role' => $_SESSION['user_role'] ?? $userType,
                    'login_time' => $_SESSION['login_time'] ?? null
                ];
            }
        }
        return null;
    }

    /**
     * Require authentication for current page
     * 
     * @param string $userType - Required user type
     * @param string $redirectPage - Page to redirect if not authenticated
     */
    public function requireAuth($userType = null, $redirectPage = 'home') {
        if (!$this->isLoggedIn($userType)) {
            header("Location: ?page={$redirectPage}");
            exit();
        }
    }

    /**
     * Check session timeout
     * 
     * @return bool - True if session has timed out
     */
    public function isSessionExpired() {
        if (!isset($_SESSION['login_time'])) {
            return true;
        }

        $timeout = defined('SESSION_TIMEOUT') ? SESSION_TIMEOUT : 3600; // 1 hour default
        return (time() - $_SESSION['login_time']) > $timeout;
    }

    /**
     * Refresh session timeout
     */
    public function refreshSession() {
        $_SESSION['login_time'] = time();
    }

    /**
     * Check if current user has the specified role
     * 
     * @param string $role - Role to check (admin, officer, jailor)
     * @return bool - True if user has the role
     */
    public function hasRole($role) {
        if (!$this->isLoggedIn()) {
            return false;
        }

        // Check if user role matches the required role
        $currentRole = $_SESSION['user_role'] ?? null;
        return $currentRole === $role;
    }
}
