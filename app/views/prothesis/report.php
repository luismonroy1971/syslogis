<div class="report-container">
    <div class="report-header">
        <h2>Reportes de Inventario</h2>
        <div class="header-actions">
            <button type="button" class="btn btn-primary" onclick="exportReport()">
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                </svg>
                Exportar Reporte
            </button>
        </div>
    </div>

    <div class="report-grid">
        <div class="report-card">
            <h3>Resumen por Tipo</h3>
            <div class="report-table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Total Items</th>
                            <th>Cantidad Total</th>
                            <th>Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report as $item): ?>
                        <tr>
                            <td><?php echo $this->escape($item['type']); ?></td>
                            <td class="text-right"><?php echo $this->escape($item['total_items']); ?></td>
                            <td class="text-right"><?php echo $this->escape($item['total_quantity']); ?></td>
                            <td class="text-right">$<?php echo number_format($item['total_value'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="chart-container" id="typeChart"></div>
        </div>

        <div class="report-card">
            <h3>Estado del Inventario</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Total de Prótesis</span>
                    <span class="stat-value"><?php echo array_sum(array_column($report, 'total_items')); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Valor Total del Inventario</span>
                    <span class="stat-value">$<?php echo number_format(array_sum(array_column($report, 'total_value')), 2); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Tipos Diferentes</span>
                    <span class="stat-value"><?php echo count($report); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Cantidad Total en Stock</span>
                    <span class="stat-value"><?php echo array_sum(array_column($report, 'total_quantity')); ?></span>
                </div>
            </div>
            <div class="chart-container" id="stockChart"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Preparar datos para los gráficos
const reportData = <?php echo json_encode($report); ?>;

// Gráfico de tipos de prótesis
const typeCtx = document.getElementById('typeChart').getContext('2d');
new Chart(typeCtx, {
    type: 'pie',
    data: {
        labels: reportData.map(item => item.type),
        datasets: [{
            data: reportData.map(item => item.total_items),
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'right'
            },
            title: {
                display: true,
                text: 'Distribución por Tipo'
            }
        }
    }
});

// Gráfico de valor del inventario
const stockCtx = document.getElementById('stockChart').getContext('2d');
new Chart(stockCtx, {
    type: 'bar',
    data: {
        labels: reportData.map(item => item.type),
        datasets: [{
            label: 'Valor del Inventario',
            data: reportData.map(item => item.total_value),
            backgroundColor: '#36A2EB'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Valor del Inventario por Tipo'
            }
        }
    }
});

function exportReport() {
    // Implementar exportación a PDF o Excel
    alert('Función de exportación en desarrollo');
}
</script>