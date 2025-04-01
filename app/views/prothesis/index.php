<div class="inventory-dashboard">
    <div class="dashboard-header">
        <h2>Inventario de Prótesis</h2>
        <div class="header-actions">
            <a href="<?php echo $this->url('prothesis/create'); ?>" class="btn btn-primary">
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Nueva Prótesis
            </a>
        </div>
    </div>

    <?php if (!empty($lowStock)): ?>
    <div class="alert-section">
        <div class="alert alert-warning">
            <h3>Alertas de Stock Bajo</h3>
            <div class="alert-items">
                <?php foreach ($lowStock as $item): ?>
                <div class="alert-item">
                    <span class="item-code"><?php echo $this->escape($item['code']); ?></span>
                    <span class="item-name"><?php echo $this->escape($item['name']); ?></span>
                    <span class="item-quantity">Stock: <?php echo $this->escape($item['stock_quantity']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($expiring)): ?>
    <div class="alert-section">
        <div class="alert alert-info">
            <h3>Próximos a Vencer</h3>
            <div class="alert-items">
                <?php foreach ($expiring as $item): ?>
                <div class="alert-item">
                    <span class="item-code"><?php echo $this->escape($item['code']); ?></span>
                    <span class="item-name"><?php echo $this->escape($item['name']); ?></span>
                    <span class="item-date">Vence: <?php echo date('d/m/Y', strtotime($item['expiry_date'])); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="inventory-table">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Tamaño</th>
                    <th>Fabricante</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($protheses as $prothesis): ?>
                <tr>
                    <td><?php echo $this->escape($prothesis['code']); ?></td>
                    <td><?php echo $this->escape($prothesis['name']); ?></td>
                    <td><?php echo $this->escape($prothesis['type']); ?></td>
                    <td><?php echo $this->escape($prothesis['size']); ?></td>
                    <td><?php echo $this->escape($prothesis['manufacturer']); ?></td>
                    <td class="stock-cell <?php echo $prothesis['stock_quantity'] <= $prothesis['minimum_stock'] ? 'low-stock' : ''; ?>">
                        <?php echo $this->escape($prothesis['stock_quantity']); ?>
                    </td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower($prothesis['status']); ?>">
                            <?php echo $this->escape($prothesis['status']); ?>
                        </span>
                    </td>
                    <td class="actions-cell">
                        <button type="button" class="btn btn-icon" onclick="updateStock(<?php echo $prothesis['id']; ?>)">
                            <svg viewBox="0 0 24 24" width="24" height="24">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                        </button>
                        <a href="<?php echo $this->url('prothesis/edit/' . $prothesis['id']); ?>" class="btn btn-icon">
                            <svg viewBox="0 0 24 24" width="24" height="24">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                        </a>
                        <button type="button" class="btn btn-icon btn-danger" onclick="deleteProthesis(<?php echo $prothesis['id']; ?>)">
                            <svg viewBox="0 0 24 24" width="24" height="24">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="stockModal" class="modal">
    <div class="modal-content">
        <h3>Actualizar Stock</h3>
        <form id="stockForm">
            <input type="hidden" name="prothesis_id" id="prothesis_id">
            <input type="hidden" name="csrf_token" value="<?php echo $this->csrf(); ?>">
            
            <div class="form-group">
                <label for="quantity">Cantidad:</label>
                <input type="number" id="quantity" name="quantity" required min="1">
            </div>
            
            <div class="form-group">
                <label>Operación:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="operation" value="add" checked>
                        Agregar
                    </label>
                    <label>
                        <input type="radio" name="operation" value="subtract">
                        Restar
                    </label>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
function updateStock(id) {
    document.getElementById('prothesis_id').value = id;
    document.getElementById('stockModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('stockModal').style.display = 'none';
    document.getElementById('stockForm').reset();
}

function deleteProthesis(id) {
    if (confirm('¿Está seguro de que desea eliminar esta prótesis?')) {
        fetch(`/prothesis/delete/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo $this->csrf(); ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar la prótesis');
            }
        });
    }
}

document.getElementById('stockForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const id = formData.get('prothesis_id');
    
    fetch(`/prothesis/updateStock/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo $this->csrf(); ?>',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            quantity: parseInt(formData.get('quantity')),
            operation: formData.get('operation')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'Error al actualizar el stock');
        }
    });
});
</script>