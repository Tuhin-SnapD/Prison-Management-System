<?php
/**
 * Example Controller
 * 
 * Demonstrates how to use the BaseController for CRUD operations
 */

require_once SRC_PATH . '/includes/controllers/BaseController.php';
require_once SRC_PATH . '/includes/utils/ErrorHandler.php';

class ExampleController extends BaseController {
    protected $table = 'example_table';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'description', 'status'];
    protected $validationRules = [
        'name' => [
            'required' => true,
            'type' => 'string',
            'min_length' => 2,
            'max_length' => 100
        ],
        'email' => [
            'required' => true,
            'type' => 'email',
            'email' => true
        ],
        'description' => [
            'required' => false,
            'type' => 'string',
            'max_length' => 500
        ],
        'status' => [
            'required' => true,
            'type' => 'string'
        ]
    ];

    public function __construct($pdo) {
        parent::__construct($pdo);
    }

    /**
     * Display list of records
     */
    public function index() {
        try {
            // Check authentication
            $this->auth->requireAuth();
            
            // Get paginated results
            $page = $_GET['page'] ?? 1;
            $search = $_GET['search'] ?? '';
            
            $conditions = [];
            if (!empty($search)) {
                $results = $this->search($search, ['name', 'email'], $conditions);
            } else {
                $results = $this->paginate($page, 10, $conditions, 'created_at DESC');
            }
            
            // Render view
            $this->render('example/index', [
                'records' => $results['data'] ?? $results,
                'pagination' => $results['pagination'] ?? null,
                'search' => $search
            ]);
            
        } catch (Exception $e) {
            ErrorHandler::getInstance()->logDatabaseError($e);
            $this->redirect('error', ['message' => 'Failed to load records']);
        }
    }

    /**
     * Display single record
     */
    public function show($id) {
        try {
            $this->auth->requireAuth();
            
            $record = $this->getById($id);
            if (!$record) {
                $this->redirect('error', ['message' => 'Record not found']);
            }
            
            $this->render('example/show', ['record' => $record]);
            
        } catch (Exception $e) {
            ErrorHandler::getInstance()->logDatabaseError($e);
            $this->redirect('error', ['message' => 'Failed to load record']);
        }
    }

    /**
     * Display create form
     */
    public function create() {
        $this->auth->requireAuth();
        $this->render('example/create');
    }

    /**
     * Store new record
     */
    public function store() {
        try {
            $this->auth->requireAuth();
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->redirect('example/create');
            }
            
            $result = $this->create($_POST);
            
            if ($result['success']) {
                $this->redirect('example/index', ['success' => 'Record created successfully']);
            } else {
                $this->redirect('example/create', [
                    'error' => $result['message'],
                    'errors' => $result['errors'] ?? [],
                    'old' => $_POST
                ]);
            }
            
        } catch (Exception $e) {
            ErrorHandler::getInstance()->logDatabaseError($e);
            $this->redirect('example/create', ['error' => 'Failed to create record']);
        }
    }

    /**
     * Display edit form
     */
    public function edit($id) {
        try {
            $this->auth->requireAuth();
            
            $record = $this->getById($id);
            if (!$record) {
                $this->redirect('error', ['message' => 'Record not found']);
            }
            
            $this->render('example/edit', ['record' => $record]);
            
        } catch (Exception $e) {
            ErrorHandler::getInstance()->logDatabaseError($e);
            $this->redirect('error', ['message' => 'Failed to load record']);
        }
    }

    /**
     * Update record
     */
    public function update($id) {
        try {
            $this->auth->requireAuth();
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->redirect('example/edit', ['id' => $id]);
            }
            
            $result = $this->update($id, $_POST);
            
            if ($result['success']) {
                $this->redirect('example/index', ['success' => 'Record updated successfully']);
            } else {
                $this->redirect('example/edit', [
                    'id' => $id,
                    'error' => $result['message'],
                    'errors' => $result['errors'] ?? [],
                    'old' => $_POST
                ]);
            }
            
        } catch (Exception $e) {
            ErrorHandler::getInstance()->logDatabaseError($e);
            $this->redirect('example/edit', ['id' => $id, 'error' => 'Failed to update record']);
        }
    }

    /**
     * Delete record
     */
    public function delete($id) {
        try {
            $this->auth->requireAuth();
            
            $result = $this->delete($id);
            
            if ($result['success']) {
                $this->redirect('example/index', ['success' => 'Record deleted successfully']);
            } else {
                $this->redirect('example/index', ['error' => $result['message']]);
            }
            
        } catch (Exception $e) {
            ErrorHandler::getInstance()->logDatabaseError($e);
            $this->redirect('example/index', ['error' => 'Failed to delete record']);
        }
    }

    /**
     * API endpoint for AJAX requests
     */
    public function api() {
        try {
            $this->auth->requireAuth();
            
            $action = $_GET['action'] ?? '';
            $response = ['success' => false, 'message' => 'Invalid action'];
            
            switch ($action) {
                case 'list':
                    $page = $_GET['page'] ?? 1;
                    $results = $this->paginate($page, 10);
                    $response = ['success' => true, 'data' => $results];
                    break;
                    
                case 'search':
                    $search = $_GET['q'] ?? '';
                    $results = $this->search($search, ['name', 'email']);
                    $response = ['success' => true, 'data' => $results];
                    break;
                    
                case 'create':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $result = $this->create($_POST);
                        $response = $result;
                    }
                    break;
                    
                case 'update':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $id = $_GET['id'] ?? null;
                        if ($id) {
                            $result = $this->update($id, $_POST);
                            $response = $result;
                        }
                    }
                    break;
                    
                case 'delete':
                    $id = $_GET['id'] ?? null;
                    if ($id) {
                        $result = $this->delete($id);
                        $response = $result;
                    }
                    break;
            }
            
            $this->jsonResponse($response);
            
        } catch (Exception $e) {
            ErrorHandler::getInstance()->logDatabaseError($e);
            $this->jsonResponse(['success' => false, 'message' => 'Server error'], 500);
        }
    }
}
