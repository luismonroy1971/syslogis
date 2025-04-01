<?php

class ProthesisModel extends Model {
    protected $table = 'protheses';
    protected $fillable = [
        'code',
        'name',
        'type',
        'size',
        'manufacturer',
        'supplier',
        'purchase_date',
        'expiry_date',
        'cost',
        'stock_quantity',
        'minimum_stock',
        'location',
        'status',
        'notes'
    ];

    protected $validationRules = [
        'code' => 'required',
        'name' => 'required',
        'type' => 'required',
        'size' => 'required',
        'manufacturer' => 'required',
        'supplier' => 'required',
        'purchase_date' => 'required|date',
        'expiry_date' => 'required|date',
        'cost' => 'required|numeric',
        'stock_quantity' => 'required|numeric',
        'minimum_stock' => 'required|numeric',
        'location' => 'required',
        'status' => 'required'
    ];

    public function searchByCode($code) {
        $sql = "SELECT * FROM {$this->table} WHERE code LIKE ?";
        return $this->db->query($sql, ["%$code%"])->fetchAll();
    }

    public function getLowStockItems() {
        $sql = "SELECT * FROM {$this->table} WHERE stock_quantity <= minimum_stock";
        return $this->db->query($sql)->fetchAll();
    }

    public function getExpiringItems($days = 30) {
        $sql = "SELECT * FROM {$this->table} WHERE expiry_date <= DATE_ADD(CURDATE(), INTERVAL ? DAY)";
        return $this->db->query($sql, [$days])->fetchAll();
    }

    public function updateStock($id, $quantity, $operation = 'add') {
        $prothesis = $this->find($id);
        if (!$prothesis) {
            return false;
        }

        $newQuantity = $operation === 'add' 
            ? $prothesis['stock_quantity'] + $quantity
            : $prothesis['stock_quantity'] - $quantity;

        if ($newQuantity < 0) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET stock_quantity = ? WHERE id = ?";
        return $this->db->query($sql, [$newQuantity, $id]) !== false;
    }

    public function getInventoryReport() {
        $sql = "SELECT 
                type,
                COUNT(*) as total_items,
                SUM(stock_quantity) as total_quantity,
                SUM(cost * stock_quantity) as total_value
            FROM {$this->table}
            GROUP BY type";
        return $this->db->query($sql)->fetchAll();
    }

    protected function validateRule($field, $value, $rule) {
        if (parent::validateRule($field, $value, $rule) === false) {
            return false;
        }

        switch ($rule) {
            case 'date':
                if (!strtotime($value)) {
                    $this->addError("El campo $field debe ser una fecha válida");
                    return false;
                }
                break;
        }
        return true;
    }
}