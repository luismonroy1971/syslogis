<?php

abstract class Controller {
    protected $view;
    protected $model;
    protected $request;
    protected $response;
    protected $middleware = [];

    public function __construct() {
        $this->view = new View();
        $this->request = $this->parseRequest();
        $this->response = [
            'status' => 200,
            'headers' => [],
            'body' => ''
        ];
    }

    protected function parseRequest() {
        return [
            'method' => $_SERVER['REQUEST_METHOD'],
            'uri' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            'query' => $_GET,
            'body' => $this->getRequestBody(),
            'headers' => getallheaders(),
            'files' => $_FILES
        ];
    }

    protected function getRequestBody() {
        $body = file_get_contents('php://input');
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
        
        if (strpos($contentType, 'application/json') !== false) {
            return json_decode($body, true);
        }
        
        return $_POST;
    }

    protected function json($data, $status = 200) {
        $this->response['status'] = $status;
        $this->response['headers']['Content-Type'] = 'application/json';
        $this->response['body'] = json_encode($data);
        return $this;
    }

    protected function loadModel($modelName) {
        $modelFile = APP_PATH . '/models/' . $modelName . 'Model.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            $modelClass = $modelName . 'Model';
            return new $modelClass();
        }
        throw new Exception("Model $modelName not found");
    }

    protected function view($view, $data = [], $status = 200) {
        $this->response['status'] = $status;
        $this->response['headers']['Content-Type'] = 'text/html';
        $this->response['body'] = $this->view->render($view, $data);
        return $this;
    }

    protected function redirect($url, $status = 302) {
        header('Location: ' . $url);
        exit;
    }

    protected function addMiddleware($middleware) {
        $this->middleware[] = $middleware;
        return $this;
    }

    protected function runMiddleware() {
        foreach ($this->middleware as $middleware) {
            if (!$middleware->handle($this->request, $this->response)) {
                return false;
            }
        }
        return true;
    }

    public function sendResponse() {
        if (!$this->runMiddleware()) {
            return;
        }

        http_response_code($this->response['status']);
        
        foreach ($this->response['headers'] as $name => $value) {
            header("$name: $value");
        }
        
        echo $this->response['body'];
    }

    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $ruleArray = explode('|', $fieldRules);
            
            foreach ($ruleArray as $rule) {
                if ($rule === 'required' && (!isset($data[$field]) || empty($data[$field]))) {
                    $errors[$field][] = "El campo $field es requerido";
                    continue;
                }
                
                if (isset($data[$field])) {
                    $value = $data[$field];
                    
                    switch ($rule) {
                        case 'numeric':
                            if (!is_numeric($value)) {
                                $errors[$field][] = "El campo $field debe ser numérico";
                            }
                            break;
                            
                        case 'email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $errors[$field][] = "El campo $field debe ser un email válido";
                            }
                            break;
                    }
                }
            }
        }
        
        return empty($errors) ? true : $errors;
    }

    protected function csrf() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf() {
        if (!isset($_SESSION['csrf_token']) || 
            !isset($this->request['headers']['X-CSRF-TOKEN']) || 
            $_SESSION['csrf_token'] !== $this->request['headers']['X-CSRF-TOKEN']) {
            throw new Exception('CSRF token mismatch');
        }
    }
}