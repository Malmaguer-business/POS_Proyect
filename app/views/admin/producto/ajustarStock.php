<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustar Stock - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/producto/ajustarStock.css">
    <script src="../app/views/admin/producto/ajustarStock.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>📊 Ajustar Stock</h1>
        <a href="index.php?c=producto&a=gestionar" class="back-btn">← Volver</a>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="stock-container">

        <!-- PRODUCT INFO CARD -->
        <div class="product-card">
            <div class="product-header">
                <div class="product-icon">📦</div>
                <div class="product-details">
                    <h2 id="productName"><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                    <div class="product-code">
                        Código: <?php echo htmlspecialchars($producto['codigo_barras']); ?>
                    </div>
                </div>
            </div>

            <div class="product-info-grid">
                <div class="info-item">
                    <div class="info-label">Categoría</div>
                    <div class="info-value"><?php echo htmlspecialchars($producto['categoria_nombre'] ?? 'Sin categoría'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Precio</div>
                    <div class="info-value">$<?php echo number_format($producto['precio'], 2); ?></div>
                </div>
            </div>
        </div>

        <!-- STOCK DISPLAY -->
        <div class="stock-display">
            <div class="stock-label">Stock Actual</div>
            <div class="stock-value" id="currentStock"><?php echo $producto['stock']; ?></div>
            <div class="stock-min">Stock mínimo: <span id="minStock"><?php echo $producto['stock_minimo']; ?></span></div>
            <div class="stock-status" id="stockStatus"></div>
        </div>

        <!-- ALERT -->
        <div id="alert" class="alert"></div>

        <!-- STOCK CONTROLS -->
        <div class="stock-controls">
            <div class="controls-header">
                <h3>Ajustar Inventario</h3>
                <p>Ingresa la cantidad y selecciona si deseas aumentar o disminuir</p>
            </div>

            <div class="control-group">
                <div class="amount-input">
                    <button type="button" onclick="decrementAmount()">−</button>
                    <input type="number" id="amount" value="1" min="1" max="9999">
                    <button type="button" onclick="incrementAmount()">+</button>
                </div>

                <div class="action-buttons">
                    <button class="btn-action btn-increase" onclick="ajustarStock('aumentar')">
                        <span>➕</span> Aumentar
                    </button>
                    <button class="btn-action btn-decrease" onclick="ajustarStock('disminuir')">
                        <span>➖</span> Disminuir
                    </button>
                </div>
            </div>

            <div class="last-update" id="lastUpdate">
                Última actualización: Ahora
            </div>
        </div>

    </main>

    <script>
        const productoId = '<?php echo $producto['id']; ?>';
        let actualizacionInterval;

        document.addEventListener('DOMContentLoaded', function() {
            actualizarEstadoStock();
            
            // Actualizar cada 5 segundos
            actualizacionInterval = setInterval(obtenerStockActual, 5000);
        });

        function incrementAmount() {
            const input = document.getElementById('amount');
            input.value = parseInt(input.value) + 1;
        }

        function decrementAmount() {
            const input = document.getElementById('amount');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        async function ajustarStock(accion) {
            const cantidad = parseInt(document.getElementById('amount').value);

            if (cantidad <= 0) {
                mostrarAlerta('La cantidad debe ser mayor a 0', 'error');
                return;
            }

            // Deshabilitar botones mientras se procesa
            const buttons = document.querySelectorAll('.btn-action');
            buttons.forEach(btn => btn.disabled = true);

            try {
                const formData = new FormData();
                formData.append('id', productoId);
                formData.append('cantidad', cantidad);
                formData.append('accion', accion);

                const response = await fetch('index.php?c=producto&a=modificarStock', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    mostrarAlerta(`Stock ${accion === 'aumentar' ? 'aumentado' : 'disminuido'} correctamente`, 'success');
                    // Actualizar inmediatamente
                    await obtenerStockActual();
                    // Resetear cantidad
                    document.getElementById('amount').value = 1;
                } else {
                    mostrarAlerta(data.message || 'Error al ajustar el stock', 'error');
                }

            } catch (error) {
                console.error('Error:', error);
                mostrarAlerta('Error de conexión', 'error');
            } finally {
                // Rehabilitar botones
                buttons.forEach(btn => btn.disabled = false);
            }
        }

        async function obtenerStockActual() {
            try {
                const response = await fetch(`index.php?c=producto&a=obtenerStock&id=${productoId}`);
                const data = await response.json();

                if (data.success) {
                    document.getElementById('currentStock').textContent = data.stock;
                    document.getElementById('minStock').textContent = data.stock_minimo;
                    actualizarEstadoStock(data.stock, data.stock_minimo);
                    actualizarUltimaActualizacion();
                }
            } catch (error) {
                console.error('Error al obtener stock:', error);
            }
        }

        function actualizarEstadoStock(stock, stockMinimo) {
            if (!stock) stock = parseInt(document.getElementById('currentStock').textContent);
            if (!stockMinimo) stockMinimo = parseInt(document.getElementById('minStock').textContent);

            const statusElement = document.getElementById('stockStatus');

            if (stock === 0) {
                statusElement.textContent = '⚠️ Sin stock';
                statusElement.className = 'stock-status status-danger';
            } else if (stock <= stockMinimo) {
                statusElement.textContent = '⚠️ Stock bajo';
                statusElement.className = 'stock-status status-warning';
            } else {
                statusElement.textContent = '✓ Stock normal';
                statusElement.className = 'stock-status status-ok';
            }
        }

        function actualizarUltimaActualizacion() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('es-MX');
            document.getElementById('lastUpdate').textContent = `Última actualización: ${timeString}`;
        }

        function mostrarAlerta(mensaje, tipo) {
            const alert = document.getElementById('alert');
            alert.textContent = mensaje;
            alert.className = `alert ${tipo} show`;
            
            setTimeout(() => {
                alert.classList.remove('show');
            }, 3000);
        }

        // Limpiar intervalo al salir de la página
        window.addEventListener('beforeunload', function() {
            if (actualizacionInterval) {
                clearInterval(actualizacionInterval);
            }
        });
    </script>

</body>
</html>