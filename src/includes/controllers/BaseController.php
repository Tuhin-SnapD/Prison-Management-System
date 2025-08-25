<?php
/**
 * Base Controller Class
 * 
 * Provides common CRUD operations and utility methods for all controllers
 */

abstract class BaseController {
    protected $pdo;
    protected $auth;
    protected $validator;
    protected $table;
    protected $primaryKey;
    protected $fillable = [];
    protected $validationRules = [];

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->auth = new Auth($pdo);
        $this->validator = new Validator();
    }

    /**
     * Get all records from table
     * 
     * @param array $conditions - WHERE conditions
     * @param string $orderBy - ORDER BY clause
     * @param int $limit - LIMIT clause
     * @param int $offset - OFFSET clause
     * @return array - Array of records
     */
    protected function getAll($conditions = [], $orderBy = '', $limit = null, $offset = null) {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $params = [];

            // Add WHERE conditions
            if (!empty($conditions)) {
                $whereClauses = [];
                foreach ($conditions as $field => $value) {
                    $whereClauses[] = "{$field} = :{$field}";
                    $params[":{$field}"] = $value;
                }
                $sql .= " WHERE " . implode(' AND ', $whereClauses);
            }

            // Add ORDER BY
            if (!empty($orderBy)) {
                $sql .= " ORDER BY {$orderBy}";
            }

            // Add LIMIT and OFFSET
            if ($limit !== null) {
                $sql .= " LIMIT :limit";
                $params[':limit'] = $limit;
                
                if ($offset !== null) {
                    $sql .= " OFFSET :offset";
                    $params[':offset'] = $offset;
                }
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single record by ID
     * 
     * @param mixed $id - Primary key value
     * @return array|null - Record or null if not found
     */
    protected function getById($id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error in getById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create new record
     * 
     * @param array $data - Data to insert
     * @return array - Result with success status and message
     */
    protected function create($data) {
        try {
            // Validate data
            $validation = $this->validator->validateForm($data, $this->validationRules);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validation['errors']
                ];
            }

            // Filter data to only include fillable fields
            $filteredData = array_intersect_key($validation['sanitized'], array_flip($this->fillable));
            
            if (empty($filteredData)) {
                return [
                    'success' => false,
                    'message' => 'No valid data to insert'
                ];
            }

            $fields = array_keys($filteredData);
            $placeholders = ':' . implode(', :', $fields);
            $fieldList = implode(', ', $fields);

            $sql = "INSERT INTO {$this->table} ({$fieldList}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filteredData);

            return [
                'success' => true,
                'message' => 'Record created successfully',
                'id' => $this->pdo->lastInsertId()
            ];
        } catch (PDOException $e) {
            error_log("Error in create: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error occurred'
            ];
        }
    }

    /**
     * Update existing record
     * 
     * @param mixed $id - Primary key value
     * @param array $data - Data to update
     * @return array - Result with success status and message
     */
    protected function update($id, $data) {
        try {
            // Validate data
            $validation = $this->validator->validateForm($data, $this->validationRules);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validation['errors']
                ];
            }

            // Filter data to only include fillable fields
            $filteredData = array_intersect_key($validation['sanitized'], array_flip($this->fillable));
            
            if (empty($filteredData)) {
                return [
                    'success' => false,
                    'message' => 'No valid data to update'
                ];
            }

            $setClauses = [];
            foreach ($filteredData as $field => $value) {
                $setClauses[] = "{$field} = :{$field}";
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $setClauses) . " WHERE {$this->primaryKey} = :id";
            $filteredData[':id'] = $id;

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filteredData);

            if ($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'message' => 'Record updated successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Record not found or no changes made'
                ];
            }
        } catch (PDOException $e) {
            error_log("Error in update: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error occurred'
            ];
        }
    }

    /**
     * Delete record
     * 
     * @param mixed $id - Primary key value
     * @return array - Result with success status and message
     */
    protected function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'message' => 'Record deleted successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Record not found'
                ];
            }
        } catch (PDOException $e) {
            error_log("Error in delete: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Database error occurred'
            ];
        }
    }

    /**
     * Count records
     * 
     * @param array $conditions - WHERE conditions
     * @return int - Number of records
     */
    protected function count($conditions = []) {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->table}";
            $params = [];

            if (!empty($conditions)) {
                $whereClauses = [];
                foreach ($conditions as $field => $value) {
                    $whereClauses[] = "{$field} = :{$field}";
                    $params[":{$field}"] = $value;
                }
                $sql .= " WHERE " . implode(' AND ', $whereClauses);
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            
            return (int) $result['count'];
        } catch (PDOException $e) {
            error_log("Error in count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Search records
     * 
     * @param string $searchTerm - Search term
     * @param array $searchFields - Fields to search in
     * @param array $conditions - Additional WHERE conditions
     * @return array - Array of matching records
     */
    protected function search($searchTerm, $searchFields = [], $conditions = []) {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $params = [];
            $whereClauses = [];

            // Add search conditions
            if (!empty($searchTerm) && !empty($searchFields)) {
                $searchClauses = [];
                foreach ($searchFields as $field) {
                    $searchClauses[] = "{$field} LIKE :search";
                }
                $whereClauses[] = "(" . implode(' OR ', $searchClauses) . ")";
                $params[':search'] = "%{$searchTerm}%";
            }

            // Add additional conditions
            foreach ($conditions as $field => $value) {
                $whereClauses[] = "{$field} = :{$field}";
                $params[":{$field}"] = $value;
            }

            if (!empty($whereClauses)) {
                $sql .= " WHERE " . implode(' AND ', $whereClauses);
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in search: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Paginate results
     * 
     * @param int $page - Current page number
     * @param int $perPage - Records per page
     * @param array $conditions - WHERE conditions
     * @param string $orderBy - ORDER BY clause
     * @return array - Paginated results with metadata
     */
    protected function paginate($page = 1, $perPage = 10, $conditions = [], $orderBy = '') {
        $offset = ($page - 1) * $perPage;
        $total = $this->count($conditions);
        $records = $this->getAll($conditions, $orderBy, $perPage, $offset);
        
        return [
            'data' => $records,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => ceil($total / $perPage),
                'has_next' => $page < ceil($total / $perPage),
                'has_prev' => $page > 1
            ]
        ];
    }

    /**
     * Execute custom query
     * 
     * @param string $sql - SQL query
     * @param array $params - Query parameters
     * @return array - Query results
     */
    protected function executeQuery($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in executeQuery: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Begin transaction
     */
    protected function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    /**
     * Commit transaction
     */
    protected function commit() {
        $this->pdo->commit();
    }

    /**
     * Rollback transaction
     */
    protected function rollback() {
        $this->pdo->rollback();
    }

    /**
     * Render view with data
     * 
     * @param string $view - View file path
     * @param array $data - Data to pass to view
     */
    protected function render($view, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Include view file
        $viewPath = SRC_PATH . '/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            throw new Exception("View file not found: {$viewPath}");
        }
    }

    /**
     * Redirect to another page
     * 
     * @param string $page - Page to redirect to
     * @param array $params - Query parameters
     */
    protected function redirect($page, $params = []) {
        $url = "?page={$page}";
        if (!empty($params)) {
            $url .= '&' . http_build_query($params);
        }
        header("Location: {$url}");
        exit();
    }

    /**
     * Return JSON response
     * 
     * @param mixed $data - Data to return
     * @param int $statusCode - HTTP status code
     */
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
