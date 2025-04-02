<?php

class DashboardController extends Controller {
    public function __construct() {
        parent::__construct();
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            return $this->redirect(BASE_URL . 'auth/login');
        }
    }

    public function index() {
        $data = [
            'title' => 'Dashboard',
            'user_name' => $_SESSION['user_name'] ?? 'Usuario'
        ];
        $this->view('dashboard/index', $data);
    }
}