// TABS
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                document.getElementById(this.dataset.tab).classList.add('active');
            });
        });

        // (No formatter) We'll display the raw YYYY-MM-DD values to keep MySQL-compatible format.

        // BUSCAR POR FECHAS
        async function buscarPorFechas() {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;

            if (!fechaInicio || !fechaFin) {
                alert('Por favor selecciona ambas fechas');
                return;
            }

            document.getElementById('results-fechas').innerHTML ='<div class="loading">Cargando...</div>';

            try {
                const response = await fetch(
                    `index.php?c=venta&a=buscarPorFechas&fecha_inicio=${encodeURIComponent(fechaInicio)}&fecha_fin=${encodeURIComponent(fechaFin)}`
                );

                const data = await response.json();

                if (data.success) {
                    mostrarResultados(data.ventas, 'fechas');
                    mostrarEstadisticas(data.ventas, 'fechas');
                } else {
                    document.getElementById('results-fechas').innerHTML = '<div class="empty-state"><div class="icon">📭</div><p>No se encontraron ventas</p></div>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('results-fechas').innerHTML = '<div class="empty-state"><div class="icon">⚠️</div><p>Error al cargar ventas</p></div>';
            }
        }

        // BUSCAR POR USUARIO
        async function buscarPorUsuario() {
            const usuarioId = document.getElementById('select_usuario').value;

            if (!usuarioId) {
                alert('Por favor selecciona un usuario');
                return;
            }

            document.getElementById('results-usuario').innerHTML = '<div class="loading">Cargando...</div>';

            try {
                const response = await fetch(`index.php?c=venta&a=buscarPorUsuario&usuario_id=${usuarioId}`);
                const data = await response.json();

                if (data.success) {
                    mostrarResultados(data.ventas, 'usuario');
                    mostrarEstadisticas(data.ventas, 'usuario');
                } else {
                    document.getElementById('results-usuario').innerHTML = '<div class="empty-state"><div class="icon">📭</div><p>No se encontraron ventas</p></div>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('results-usuario').innerHTML = '<div class="empty-state"><div class="icon">⚠️</div><p>Error al cargar ventas</p></div>';
            }
        }

        // BUSCAR POR PRODUCTO
        async function buscarPorProducto() {
            const productoId = document.getElementById('select_producto').value;

            if (!productoId) {
                alert('Por favor selecciona un producto');
                return;
            }

            document.getElementById('results-producto').innerHTML = '<div class="loading">Cargando...</div>';

            try {
                const response = await fetch(`index.php?c=venta&a=buscarPorProducto&producto_id=${productoId}`);
                const data = await response.json();

                if (data.success) {
                    mostrarResultadosProducto(data.ventas);
                    mostrarEstadisticasProducto(data.ventas);
                } else {
                    document.getElementById('results-producto').innerHTML = '<div class="empty-state"><div class="icon">📭</div><p>No se encontraron ventas</p></div>';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('results-producto').innerHTML = '<div class="empty-state"><div class="icon">⚠️</div><p>Error al cargar ventas</p></div>';
            }
        }

        // MOSTRAR RESULTADOS
        function mostrarResultados(ventas, tipo) {
            if (ventas.length === 0) {
                document.getElementById(`results-${tipo}`).innerHTML = '<div class="empty-state"><div class="icon">📭</div><p>No se encontraron ventas</p></div>';
                return;
            }

            let html = `
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Método Pago</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            ventas.forEach(venta => {
                const fecha = new Date(venta.fecha);
                const metodoBadge = venta.metodo_paga === 'efectivo' ? 'payment-efectivo' : 'payment-tarjeta';
                
                html += `
                    <tr>
                        <td>${fecha.toLocaleDateString('es-MX')} ${fecha.toLocaleTimeString('es-MX', {hour: '2-digit', minute: '2-digit'})}</td>
                        <td>${venta.usuario_nombre || 'Desconocido'}</td>
                        <td><span class="payment-badge ${metodoBadge}">${venta.metodo_paga}</span></td>
                        <td class="total-price">$${parseFloat(venta.total).toFixed(2)}</td>
                        <td><button class="btn-details" onclick="verDetalles('${venta.id}')">Ver Detalles</button></td>
                    </tr>
                `;
            });

            html += '</tbody></table>';
            document.getElementById(`results-${tipo}`).innerHTML = html;
        }

        // MOSTRAR RESULTADOS PRODUCTO
        function mostrarResultadosProducto(ventas) {
            if (ventas.length === 0) {
                document.getElementById('results-producto').innerHTML = '<div class="empty-state"><div class="icon">📭</div><p>No se encontraron ventas</p></div>';
                return;
            }

            let html = `
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Cantidad</th>
                            <th>Subtotal Producto</th>
                            <th>Total Venta</th>
                            <th>Método Pago</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            ventas.forEach(venta => {
                const fecha = new Date(venta.fecha);
                const metodoBadge = venta.metodo_paga === 'efectivo' ? 'payment-efectivo' : 'payment-tarjeta';
                
                html += `
                    <tr>
                        <td>${fecha.toLocaleDateString('es-MX')} ${fecha.toLocaleTimeString('es-MX', {hour: '2-digit', minute: '2-digit'})}</td>
                        <td>${venta.usuario_nombre || 'Desconocido'}</td>
                        <td>${venta.cantidad_producto} unidades</td>
                        <td class="total-price">$${parseFloat(venta.subtotal_producto).toFixed(2)}</td>
                        <td>$${parseFloat(venta.total).toFixed(2)}</td>
                        <td><span class="payment-badge ${metodoBadge}">${venta.metodo_paga}</span></td>
                    </tr>
                `;
            });

            html += '</tbody></table>';
            document.getElementById('results-producto').innerHTML = html;
        }

        // MOSTRAR ESTADÍSTICAS
        function mostrarEstadisticas(ventas, tipo) {
            const totalVentas = ventas.length;
            const ingresoTotal = ventas.reduce((sum, v) => sum + parseFloat(v.total), 0);

            document.getElementById(`stats-${tipo}`).style.display = 'grid';
            document.getElementById(`total-ventas-${tipo}`).textContent = totalVentas;
            document.getElementById(`ingresos-${tipo}`).textContent = `$${ingresoTotal.toFixed(2)}`;
        }

        // MOSTRAR ESTADÍSTICAS PRODUCTO
        function mostrarEstadisticasProducto(ventas) {
            const totalVentas = ventas.length;
            const cantidadTotal = ventas.reduce((sum, v) => sum + parseInt(v.cantidad_producto), 0);
            const ingresoTotal = ventas.reduce((sum, v) => sum + parseFloat(v.subtotal_producto), 0);

            document.getElementById('stats-producto').style.display = 'grid';
            document.getElementById('total-ventas-producto').textContent = totalVentas;
            document.getElementById('cantidad-producto').textContent = cantidadTotal;
            document.getElementById('ingresos-producto').textContent = `$${ingresoTotal.toFixed(2)}`;
        }

        // VER DETALLES
        function verDetalles(ventaId) {
            window.location.href = `index.php?c=venta&a=detalles&id=${ventaId}`;
        }