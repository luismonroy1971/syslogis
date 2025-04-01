<?php

class HomeController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
        
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
}