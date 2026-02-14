let chartTopProductos = null;
        let chartMetodosPago = null;

        document.addEventListener('DOMContentLoaded', function() {
            cargarResumenGeneral();
            cargarTopProductos();
            cargarMetodosPago();
            cargarRendimientoEmpleados();
            cargarProductosStockBajo();
        });

        // RESUMEN GENERAL
        async function cargarResumenGeneral() {
            try {
                const response = await fetch('index.php?c=venta&a=reporteResumen');
                const data = await response.json();

                if (data.success) {
                    const html = `
                        <div class="stat-card">
                            <div class="stat-icon">📅</div>
                            <div class="stat-label">Ventas Hoy</div>
                            <div class="stat-value">${data.resumen.ventas_hoy}</div>
                            <div class="stat-subtext">$${parseFloat(data.resumen.ingresos_hoy).toFixed(2)}</div>
                        </div>
                        <div class="stat-card green">
                            <div class="stat-icon">💰</div>
                            <div class="stat-label">Ventas del Mes</div>
                            <div class="stat-value">${data.resumen.ventas_mes}</div>
                            <div class="stat-subtext">$${parseFloat(data.resumen.ingresos_mes).toFixed(2)}</div>
                        </div>
                        <div class="stat-card orange">
                            <div class="stat-icon">🔥</div>
                            <div class="stat-label">Más Vendido Hoy</div>
                            <div class="stat-value">${data.resumen.producto_mas_vendido || 'N/A'}</div>
                            <div class="stat-subtext">${data.resumen.cantidad_vendida || 0} unidades</div>
                        </div>
                        <div class="stat-card blue">
                            <div class="stat-icon">⚠️</div>
                            <div class="stat-label">Stock Bajo</div>
                            <div class="stat-value">${data.resumen.productos_stock_bajo}</div>
                            <div class="stat-subtext">Productos a reabastecer</div>
                        </div>
                    `;
                    document.getElementById('resumenGeneral').innerHTML = html;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // TOP PRODUCTOS
        async function cargarTopProductos() {
            try {
                const response = await fetch('index.php?c=venta&a=reporteTopProductos');
                const data = await response.json();

                if (data.success && data.productos.length > 0) {
                    const labels = data.productos.map(p => p.nombre);
                    const cantidades = data.productos.map(p => parseInt(p.cantidad_vendida));

                    const ctx = document.getElementById('chartTopProductos').getContext('2d');
                    
                    if (chartTopProductos) {
                        chartTopProductos.destroy();
                    }

                    chartTopProductos = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Cantidad Vendida',
                                data: cantidades,
                                backgroundColor: [
                                    'rgba(102, 126, 234, 0.8)',
                                    'rgba(118, 75, 162, 0.8)',
                                    'rgba(237, 100, 166, 0.8)',
                                    'rgba(255, 154, 158, 0.8)',
                                    'rgba(250, 208, 196, 0.8)'
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // MÉTODOS DE PAGO
        async function cargarMetodosPago() {
            try {
                const response = await fetch('index.php?c=venta&a=reporteMetodosPago');
                const data = await response.json();

                if (data.success && data.metodos.length > 0) {
                    const labels = data.metodos.map(m => m.metodo_paga);
                    const totales = data.metodos.map(m => parseFloat(m.total_ingresos));

                    const ctx = document.getElementById('chartMetodosPago').getContext('2d');
                    
                    if (chartMetodosPago) {
                        chartMetodosPago.destroy();
                    }

                    chartMetodosPago = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: totales,
                                backgroundColor: [
                                    'rgba(40, 167, 69, 0.8)',
                                    'rgba(0, 123, 255, 0.8)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });

                    // Stats lateral
                    let statsHtml = '<div style="padding: 1rem;">';
                    data.metodos.forEach(m => {
                        statsHtml += `
                            <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                                <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">${m.metodo_paga}</div>
                                <div style="font-size: 1.8rem; font-weight: bold; color: #333;">$${parseFloat(m.total_ingresos).toFixed(2)}</div>
                                <div style="font-size: 0.85rem; color: #999;">${m.cantidad_ventas} ventas</div>
                            </div>
                        `;
                    });
                    statsHtml += '</div>';
                    document.getElementById('metodosPagoStats').innerHTML = statsHtml;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // RENDIMIENTO EMPLEADOS
        async function cargarRendimientoEmpleados() {
            try {
                const response = await fetch('index.php?c=venta&a=reporteRendimientoEmpleados');
                const data = await response.json();

                if (data.success && data.empleados.length > 0) {
                    let html = `
                        <table>
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Empleado</th>
                                    <th>Total Ventas</th>
                                    <th>Ingresos Generados</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    data.empleados.forEach((emp, index) => {
                        html += `
                            <tr>
                                <td><span class="rank">#${index + 1}</span></td>
                                <td>${emp.empleado_nombre}</td>
                                <td>${emp.total_ventas}</td>
                                <td style="font-weight: 600; color: #28a745;">$${parseFloat(emp.ingresos_generados).toFixed(2)}</td>
                            </tr>
                        `;
                    });

                    html += '</tbody></table>';
                    document.getElementById('tablaEmpleados').innerHTML = html;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // PRODUCTOS CON STOCK BAJO
        async function cargarProductosStockBajo() {
            try {
                const response = await fetch('index.php?c=venta&a=reporteProductosStockBajo');
                const data = await response.json();

                if (data.success) {
                    if (data.productos.length > 0) {
                        let html = `
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Stock Actual</th>
                                        <th>Stock Mínimo</th>
                                        <th>Unidades Faltantes</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        data.productos.forEach(prod => {
                            const porcentaje = (prod.stock_actual / prod.stock_minimo) * 100;
                            let estadoClass = 'stock-critico';
                            let estadoTexto = 'CRÍTICO';
                            
                            if (porcentaje > 50) {
                                estadoClass = 'stock-bajo';
                                estadoTexto = 'BAJO';
                            } else if (porcentaje <= 25) {
                                estadoClass = 'stock-critico';
                                estadoTexto = 'CRÍTICO';
                            } else if (porcentaje <= 50) {
                                estadoClass = 'stock-muy-bajo';
                                estadoTexto = 'MUY BAJO';
                            }

                            html += `
                                <tr>
                                    <td><strong>${prod.nombre}</strong></td>
                                    <td style="font-weight: 600; color: #dc3545;">${prod.stock_actual}</td>
                                    <td>${prod.stock_minimo}</td>
                                    <td style="color: #856404;">${prod.unidades_faltantes}</td>
                                    <td><span class="alert-badge ${estadoClass}">${estadoTexto}</span></td>
                                </tr>
                            `;
                        });

                        html += '</tbody></table>';
                        document.getElementById('tablaStockBajo').innerHTML = html;
                    } else {
                        document.getElementById('tablaStockBajo').innerHTML = `
                            <div style="text-align: center; padding: 2rem; color: #28a745;">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
                                <div style="font-size: 1.2rem; font-weight: 600;">¡Todos los productos tienen stock suficiente!</div>
                            </div>
                        `;
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('tablaStockBajo').innerHTML = '<div class="loading">Error al cargar datos</div>';
            }
        }