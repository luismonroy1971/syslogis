<?php

abstract class Model {
    protected $db;
    protected $table;
    protected $fillable = [];
    protected $validationRules = [];

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->query($sql)->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function create(array $data) {
        if (!$this->validate($data)) {
            return false;
        }

        $filteredData = $this->filterFillableData($data);
        $columns = implode(',', array_keys($filteredData));
        $values = implode(',', array_fill(0, count($filteredData), '?'));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        
        if ($this->db->query($sql, array_values($filteredData))) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, array $data) {
        if (!$this->validate($data)) {
            return false;
        }

        $filteredData = $this->filterFillableData($data);
        $setStatements = [];
        foreach ($filteredData as $column => $value) {
            $setStatements[] = "$column = ?";
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(',', $setStatements) . " WHERE id = ?";
        $params = array_merge(array_values($filteredData), [$id]);
        
        return $this->db->query($sql, $params) !== false;
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->query($sql, [$id]) !== false;
    }

    protected function validate(array $data) {
        foreach ($this->validationRules as $field => $rules) {
            if (!isset($data[$field]) && strpos($rules, 'required') !== false) {
                $this->addError("El campo $field es requerido");
                return false;
            }
            
            if (isset($data[$field])) {
                $value = $data[$field];
                $ruleArray = explode('|', $rules);
                
                foreach ($ruleArray as $rule) {
                    if (!$this->validateRule($field, $value, $rule)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    protected function validateRule($field, $value, $rule) {
        switch ($rule) {
            case 'required':
                if (empty($value)) {
                    $this->addError("El campo $field no puede estar vacío");
                    return false;
                }
                break;
                
            case 'numeric':
                if (!is_numeric($value)) {
                    $this->addError("El campo $field debe ser numérico");
                    return false;
                }
                break;
                
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError("El campo $field debe ser un email válido");
                    return false;
                }
                break;
        }
        return true;
    }

    protected function filterFillableData(array $data) {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    protected function addError($message) {
        // Implementar sistema de manejo de errores
        error_log($message);
    }
}