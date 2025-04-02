<?php

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = $this->loadModel('User');
    }

    public function index() {
        $this->login();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->view('auth/login', ['error' => 'Por favor ingrese su email y contraseña']);
                return;
            }

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_role'] = $user['rol_id'];
                
                return $this->redirect(BASE_URL . 'dashboard');
            }

            $this->view('auth/login', ['error' => 'Credenciales inválidas']);
            return;
        }

        $this->view('auth/login');
    }

    public function logout() {
        session_destroy();
        return $this->redirect(BASE_URL . 'auth/login');
    }
}