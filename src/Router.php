<?php

class Router {
    protected $routes = [];
    protected $auth;

    public function __construct() {
        global $auth;
        $this->auth = $auth;
    }

    public function add($method, $uri, $controller, $options = []) {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'requires_auth' => $options['requires_auth'] ?? false,
            'required_role' => $options['required_role'] ?? null,
            'redirect_url' => $options['redirect_url'] ?? 'signin-admin'
        ];
    }

    public function get($uri, $controller, $options = []) {
        $this->add('GET', $uri, $controller, $options);
        return $this; // Allow chaining
    }

    public function post($uri, $controller, $options = []) {
        $this->add('POST', $uri, $controller, $options);
        return $this; // Allow chaining
    }

    public function auth($required_role = null, $redirect_url = 'signin-admin') {
        $this->routes[count($this->routes) - 1]['requires_auth'] = true;
        $this->routes[count($this->routes) - 1]['required_role'] = $required_role;
        $this->routes[count($this->routes) - 1]['redirect_url'] = $redirect_url;
        return $this;
    }

    public function dispatch() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $routeUri = ltrim($route['uri'], '/');
            if ($routeUri === $page && $route['method'] === $method) {
                
                // Check authentication
                if ($route['requires_auth']) {
                    if (!$this->auth->isLoggedIn()) {
                        redirect($route['redirect_url']);
                    }
                    
                    // Check role if required
                    if ($route['required_role'] && !$this->auth->hasRole($route['required_role'])) {
                        redirect('home');
                    }
                }
                
                require_once SRC_PATH . '/' . $route['controller'];
                return;
            }
        }

        // Handle 404
        require_once SRC_PATH . '/views/components/error.php';
    }
}
