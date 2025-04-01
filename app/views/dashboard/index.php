<?php $this->layout('layouts/default'); ?>

<div class="dashboard">
    <header class="dashboard-header">
        <h2>Dashboard</h2>
        <div class="date-filter">
            <select id="periodFilter" class="form-control">
                <option value="today">Hoy</option>
                <option value="week">Esta Semana</option>
                <option value="month" selected>Este Mes</option>
                <option value="year">Este Año</option>
            </select>
        </div>
    </header>

    <div class="dashboard-grid">
        <!-- Widget de Inventario Total -->
        <div class="dashboard-widget">
            <div class="widget-header">
                <h3>Inventario Total</h3>
                <span class="widget-icon">
                    <svg viewBox="0 0 24 24" width="24" height="24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                        <path d="M7 12h2v5H7zm4-3h2v8h-2zm4-3h2v11h-2z"/>
                    </svg>
                </span>
            </div>
            <div class="widget-content">
                <div class="widget-value"><?php echo $total_inventory; ?></div>
                <div class="widget-label">Prótesis en Stock</div>
            </div>
        </div>

        <!-- Widget de Movimientos Recientes -->
        <div class="dashboard-widget">
            <div class="widget-header">
                <h3>Movimientos Recientes</h3>
                <span class="widget-icon">
                    <svg viewBox="0 0 24 24" width="24" height="24">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1.4c0-2 4-3.1 6-3.1s6 1.1 6 3.1V19z"/>
                    </svg>
                </span>
            </div>
            <div class="widget-content">
                <div class="widget-value"><?php echo $recent_movements; ?></div>
                <div class="widget-label">En los últimos 30 días</div>
            </div>
        </div>

        <!-- Widget de Alertas -->
        <div class="dashboard-widget">
            <div class="widget-header">
                <h3>Alertas</h3>
                <span class="widget-icon alert">
                    <svg viewBox="0 0 24 24" width="24" height="24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                    </svg>
                </span>
            </div>
            <div class="widget-content">
                <div class="widget-value"><?php echo $alerts_count; ?></div>
                <div class="widget-label">Requieren Atención</div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Tendencias -->
    <div class="dashboard-chart">
        <div class="chart-header">
            <h3>Tendencias de Inventario</h3>
            <div class="chart-legend">
                <span class="legend-item">
                    <span class="legend-color" style="background: var(--primary-color)"></span>
                    Entradas
                </span>
                <span class="legend-item">
                    <span class="legend-color" style="background: var(--accent-color)"></span>
                    Salidas
                </span>
            </div>
        </div>
        <div class="chart-container" id="trendsChart">
            <!-- El gráfico se renderizará aquí via JavaScript -->
        </div>
    </div>

    <!-- Tabla de Últimas Actividades -->
    <div class="dashboard-table">
        <h3>Últimas Actividades</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_activities as $activity): ?>
                    <tr>
                        <td><?php echo $this->formatDate($activity->date); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $activity->type; ?>">
                                <?php echo $activity->type; ?>
                            </span>
                        </td>
                        <td><?php echo $activity->description; ?></td>
                        <td><?php echo $activity->user; ?></td>
                        <td>
                            <span class="status-indicator status-<?php echo $activity->status; ?>">
                                <?php echo $activity->status; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?php echo $this->asset('js/pages/dashboard.js'); ?>"></script>