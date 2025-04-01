<?php

// Definición de constantes globales de la aplicación
define('APP_PATH', dirname(__DIR__) . '/app');
define('BASE_URL', 'http://localhost:8000');

// Configuración de zona horaria
date_default_timezone_set('America/Lima');

// Configuración de errores en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);