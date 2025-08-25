<?php
/**
 * Validation Utility Class
 * 
 * Provides common validation functions for form inputs and data sanitization
 */

class Validator {
    
    /**
     * Sanitize input data
     * 
     * @param mixed $input - Input to sanitize
     * @param string $type - Type of sanitization (string, email, int, float)
     * @return mixed - Sanitized input
     */
    public static function sanitize($input, $type = 'string') {
        if (is_array($input)) {
            return array_map([self::class, 'sanitize'], $input);
        }

        switch ($type) {
            case 'email':
                return filter_var(trim($input), FILTER_SANITIZE_EMAIL);
            case 'int':
                return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
            case 'float':
                return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            case 'url':
                return filter_var(trim($input), FILTER_SANITIZE_URL);
            case 'string':
            default:
                return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }
    }

    /**
     * Validate email address
     * 
     * @param string $email - Email to validate
     * @return bool - True if valid email
     */
    public static function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate required fields
     * 
     * @param array $data - Data array
     * @param array $required - Array of required field names
     * @return array - Array of missing fields
     */
    public static function validateRequired($data, $required) {
        $missing = [];
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $missing[] = $field;
            }
        }
        return $missing;
    }

    /**
     * Validate string length
     * 
     * @param string $value - Value to check
     * @param int $min - Minimum length
     * @param int $max - Maximum length
     * @return bool - True if length is valid
     */
    public static function validateLength($value, $min = 0, $max = null) {
        $length = strlen(trim($value));
        
        if ($length < $min) {
            return false;
        }
        
        if ($max !== null && $length > $max) {
            return false;
        }
        
        return true;
    }

    /**
     * Validate numeric range
     * 
     * @param mixed $value - Value to check
     * @param int|float $min - Minimum value
     * @param int|float $max - Maximum value
     * @return bool - True if value is in range
     */
    public static function validateRange($value, $min = null, $max = null) {
        if (!is_numeric($value)) {
            return false;
        }
        
        if ($min !== null && $value < $min) {
            return false;
        }
        
        if ($max !== null && $value > $max) {
            return false;
        }
        
        return true;
    }

    /**
     * Validate date format
     * 
     * @param string $date - Date string
     * @param string $format - Expected format (default: Y-m-d)
     * @return bool - True if valid date
     */
    public static function isValidDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * Validate phone number (basic validation)
     * 
     * @param string $phone - Phone number
     * @return bool - True if valid phone number
     */
    public static function isValidPhone($phone) {
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Check if it's between 10-15 digits
        return strlen($phone) >= 10 && strlen($phone) <= 15;
    }

    /**
     * Validate file upload
     * 
     * @param array $file - $_FILES array element
     * @param array $allowedTypes - Allowed MIME types
     * @param int $maxSize - Maximum file size in bytes
     * @return array - Validation result
     */
    public static function validateFile($file, $allowedTypes = [], $maxSize = null) {
        $result = ['valid' => true, 'errors' => []];

        // Check if file was uploaded
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            $result['valid'] = false;
            $result['errors'][] = 'No file uploaded';
            return $result;
        }

        // Check file size
        if ($maxSize !== null && $file['size'] > $maxSize) {
            $result['valid'] = false;
            $result['errors'][] = 'File size exceeds limit';
        }

        // Check file type
        if (!empty($allowedTypes)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $result['valid'] = false;
                $result['errors'][] = 'File type not allowed';
            }
        }

        return $result;
    }

    /**
     * Validate password strength
     * 
     * @param string $password - Password to validate
     * @param int $minLength - Minimum length
     * @return array - Validation result with errors
     */
    public static function validatePassword($password, $minLength = 8) {
        $errors = [];

        if (strlen($password) < $minLength) {
            $errors[] = "Password must be at least {$minLength} characters long";
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Generate CSRF token
     * 
     * @return string - CSRF token
     */
    public static function generateCSRFToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Validate CSRF token
     * 
     * @param string $token - Token to validate
     * @return bool - True if valid
     */
    public static function validateCSRFToken($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Validate and sanitize form data
     * 
     * @param array $data - Form data
     * @param array $rules - Validation rules
     * @return array - Validation result
     */
    public static function validateForm($data, $rules) {
        $result = [
            'valid' => true,
            'errors' => [],
            'sanitized' => []
        ];

        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';
            
            // Sanitize value
            $sanitizedValue = self::sanitize($value, $rule['type'] ?? 'string');
            $result['sanitized'][$field] = $sanitizedValue;

            // Check required
            if (isset($rule['required']) && $rule['required'] && empty($sanitizedValue)) {
                $result['valid'] = false;
                $result['errors'][$field] = ucfirst($field) . ' is required';
                continue;
            }

            // Skip other validations if field is empty and not required
            if (empty($sanitizedValue) && !($rule['required'] ?? false)) {
                continue;
            }

            // Length validation
            if (isset($rule['min_length']) || isset($rule['max_length'])) {
                $min = $rule['min_length'] ?? 0;
                $max = $rule['max_length'] ?? null;
                
                if (!self::validateLength($sanitizedValue, $min, $max)) {
                    $result['valid'] = false;
                    $result['errors'][$field] = ucfirst($field) . ' length is invalid';
                }
            }

            // Email validation
            if (isset($rule['email']) && $rule['email']) {
                if (!self::isValidEmail($sanitizedValue)) {
                    $result['valid'] = false;
                    $result['errors'][$field] = 'Invalid email format';
                }
            }

            // Custom validation
            if (isset($rule['custom']) && is_callable($rule['custom'])) {
                $customResult = $rule['custom']($sanitizedValue);
                if (!$customResult['valid']) {
                    $result['valid'] = false;
                    $result['errors'][$field] = $customResult['message'];
                }
            }
        }

        return $result;
    }
}
