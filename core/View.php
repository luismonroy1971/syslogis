<?php

class View {
    protected $layout = 'default';
    protected $viewPath = '';
    protected $data = [];
    protected $components = [];

    public function __construct($viewPath = '') {
        $this->viewPath = $viewPath;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
        return $this;
    }

    public function layout($layout) {
        $this->layout = $layout;
        return $this;
    }

    public function render($view, $data = []) {
        $this->data = array_merge($this->data, $data);
        $viewContent = $this->renderView($view);
        
        if ($this->layout) {
            return $this->renderLayout($viewContent);
        }
        
        return $viewContent;
    }

    protected function renderView($view) {
        $viewFile = $this->resolvePath($view);
        if (!file_exists($viewFile)) {
            throw new Exception("Vista no encontrada: $view");
        }
        
        return $this->renderPhpFile($viewFile);
    }

    protected function renderLayout($content) {
        $layoutFile = $this->resolvePath("layouts/{$this->layout}");
        if (!file_exists($layoutFile)) {
            throw new Exception("Layout no encontrado: {$this->layout}");
        }
        
        $this->data['content'] = $content;
        return $this->renderPhpFile($layoutFile);
    }

    protected function renderComponent($name, $data = []) {
        if (!isset($this->components[$name])) {
            $componentFile = $this->resolvePath("components/$name");
            if (!file_exists($componentFile)) {
                throw new Exception("Componente no encontrado: $name");
            }
            $this->components[$name] = $componentFile;
        }
        
        $originalData = $this->data;
        $this->data = array_merge($this->data, $data);
        $output = $this->renderPhpFile($this->components[$name]);
        $this->data = $originalData;
        
        return $output;
    }

    protected function resolvePath($view) {
        $view = str_replace('.', '/', $view);
        return APP_PATH . "/views/$view.php";
    }

    protected function renderPhpFile($file) {
        ob_start();
        extract($this->data, EXTR_SKIP);
        include $file;
        return ob_get_clean();
    }

    public function assign($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }

    public function escape($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    public function partial($name, $data = []) {
        return $this->renderComponent($name, $data);
    }

    public function url($path) {
        return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
    }

    public function asset($path) {
        return $this->url("assets/$path");
    }
}