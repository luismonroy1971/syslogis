document.addEventListener('DOMContentLoaded', function() {
    // Configuración inicial
    const ctx = document.getElementById('trendsChart').getContext('2d');
    const periodFilter = document.getElementById('periodFilter');

    // Datos de ejemplo para el gráfico (esto debería venir del backend)
    const chartData = {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        datasets: [
            {
                label: 'Entradas',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: getComputedStyle(document.documentElement)
                    .getPropertyValue('--primary-color').trim(),
                backgroundColor: getComputedStyle(document.documentElement)
                    .getPropertyValue('--primary-light').trim(),
                tension: 0.4
            },
            {
                label: 'Salidas',
                data: [7, 11, 5, 8, 3, 7],
                borderColor: getComputedStyle(document.documentElement)
                    .getPropertyValue('--accent-color').trim(),
                backgroundColor: getComputedStyle(document.documentElement)
                    .getPropertyValue('--accent-color').trim() + '40',
                tension: 0.4
            }
        ]
    };

    // Configuración del gráfico
    const trendsChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: getComputedStyle(document.documentElement)
                        .getPropertyValue('--surface-color').trim(),
                    titleColor: getComputedStyle(document.documentElement)
                        .getPropertyValue('--text-primary').trim(),
                    bodyColor: getComputedStyle(document.documentElement)
                        .getPropertyValue('--text-secondary').trim(),
                    borderColor: getComputedStyle(document.documentElement)
                        .getPropertyValue('--divider-color').trim(),
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: getComputedStyle(document.documentElement)
                            .getPropertyValue('--divider-color').trim() + '20'
                    },
                    ticks: {
                        color: getComputedStyle(document.documentElement)
                            .getPropertyValue('--text-secondary').trim()
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: getComputedStyle(document.documentElement)
                            .getPropertyValue('--text-secondary').trim()
                    }
                }
            }
        }
    });

    // Manejador del filtro de período
    periodFilter.addEventListener('change', function(e) {
        // Aquí se debería hacer una llamada al backend para obtener los datos
        // del período seleccionado y actualizar el gráfico
        console.log('Período seleccionado:', e.target.value);
    });

    // Función para actualizar los widgets con animación
    function updateWidgetValue(element, value) {
        const current = parseInt(element.textContent);
        const target = parseInt(value);
        const duration = 1000; // 1 segundo
        const steps = 60;
        const increment = (target - current) / steps;
        let step = 0;

        const animation = setInterval(() => {
            step++;
            const newValue = Math.round(current + (increment * step));
            element.textContent = newValue;

            if (step >= steps) {
                clearInterval(animation);
                element.textContent = target;
            }
        }, duration / steps);
    }

    // Ejemplo de actualización de widgets con animación
    document.querySelectorAll('.widget-value').forEach(widget => {
        widget.addEventListener('update', function(e) {
            updateWidgetValue(this, e.detail.value);
        });
    });
});