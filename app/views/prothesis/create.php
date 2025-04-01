<div class="form-container">
    <div class="form-header">
        <h2>Nueva Prótesis</h2>
        <a href="<?php echo $this->url('prothesis'); ?>" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" width="24" height="24">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Volver al Inventario
        </a>
    </div>

    <form id="prothesisForm" method="POST" class="form-grid">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <div class="form-group">
            <label for="code">Código *</label>
            <input type="text" id="code" name="code" required
                value="<?php echo isset($data['code']) ? $this->escape($data['code']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="name">Nombre *</label>
            <input type="text" id="name" name="name" required
                value="<?php echo isset($data['name']) ? $this->escape($data['name']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="type">Tipo *</label>
            <select id="type" name="type" required>
                <option value="">Seleccione un tipo</option>
                <option value="Rodilla" <?php echo (isset($data['type']) && $data['type'] === 'Rodilla') ? 'selected' : ''; ?>>Rodilla</option>
                <option value="Cadera" <?php echo (isset($data['type']) && $data['type'] === 'Cadera') ? 'selected' : ''; ?>>Cadera</option>
                <option value="Hombro" <?php echo (isset($data['type']) && $data['type'] === 'Hombro') ? 'selected' : ''; ?>>Hombro</option>
                <option value="Codo" <?php echo (isset($data['type']) && $data['type'] === 'Codo') ? 'selected' : ''; ?>>Codo</option>
                <option value="Tobillo" <?php echo (isset($data['type']) && $data['type'] === 'Tobillo') ? 'selected' : ''; ?>>Tobillo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="size">Tamaño *</label>
            <input type="text" id="size" name="size" required
                value="<?php echo isset($data['size']) ? $this->escape($data['size']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="manufacturer">Fabricante *</label>
            <input type="text" id="manufacturer" name="manufacturer" required
                value="<?php echo isset($data['manufacturer']) ? $this->escape($data['manufacturer']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="supplier">Proveedor *</label>
            <input type="text" id="supplier" name="supplier" required
                value="<?php echo isset($data['supplier']) ? $this->escape($data['supplier']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="purchase_date">Fecha de Compra *</label>
            <input type="date" id="purchase_date" name="purchase_date" required
                value="<?php echo isset($data['purchase_date']) ? $this->escape($data['purchase_date']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="expiry_date">Fecha de Vencimiento *</label>
            <input type="date" id="expiry_date" name="expiry_date" required
                value="<?php echo isset($data['expiry_date']) ? $this->escape($data['expiry_date']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="cost">Costo *</label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" id="cost" name="cost" step="0.01" min="0" required
                    value="<?php echo isset($data['cost']) ? $this->escape($data['cost']) : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Cantidad en Stock *</label>
            <input type="number" id="stock_quantity" name="stock_quantity" min="0" required
                value="<?php echo isset($data['stock_quantity']) ? $this->escape($data['stock_quantity']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="minimum_stock">Stock Mínimo *</label>
            <input type="number" id="minimum_stock" name="minimum_stock" min="0" required
                value="<?php echo isset($data['minimum_stock']) ? $this->escape($data['minimum_stock']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="location">Ubicación *</label>
            <input type="text" id="location" name="location" required
                value="<?php echo isset($data['location']) ? $this->escape($data['location']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="status">Estado *</label>
            <select id="status" name="status" required>
                <option value="">Seleccione un estado</option>
                <option value="Disponible" <?php echo (isset($data['status']) && $data['status'] === 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                <option value="Agotado" <?php echo (isset($data['status']) && $data['status'] === 'Agotado') ? 'selected' : ''; ?>>Agotado</option>
                <option value="Próximo a Vencer" <?php echo (isset($data['status']) && $data['status'] === 'Próximo a Vencer') ? 'selected' : ''; ?>>Próximo a Vencer</option>
            </select>
        </div>

        <div class="form-group full-width">
            <label for="notes">Notas</label>
            <textarea id="notes" name="notes" rows="4"><?php echo isset($data['notes']) ? $this->escape($data['notes']) : ''; ?></textarea>
        </div>

        <div class="form-actions full-width">
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="submit" class="btn btn-primary">Guardar Prótesis</button>
        </div>
    </form>
</div>

<script>
document.getElementById('prothesisForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validación básica del formulario
    const requiredFields = [
        'code', 'name', 'type', 'size', 'manufacturer', 'supplier',
        'purchase_date', 'expiry_date', 'cost', 'stock_quantity',
        'minimum_stock', 'location', 'status'
    ];

    let isValid = true;
    const errors = [];

    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('error');
            errors.push(`El campo ${field.replace('_', ' ')} es requerido`);
        } else {
            input.classList.remove('error');
        }
    });

    // Validaciones específicas
    const purchaseDate = new Date(document.getElementById('purchase_date').value);
    const expiryDate = new Date(document.getElementById('expiry_date').value);

    if (expiryDate <= purchaseDate) {
        isValid = false;
        errors.push('La fecha de vencimiento debe ser posterior a la fecha de compra');
    }

    if (!isValid) {
        const errorList = errors.join('\n');
        alert('Por favor corrija los siguientes errores:\n\n' + errorList);
        return;
    }

    // Envío del formulario
    this.submit();
});
</script>