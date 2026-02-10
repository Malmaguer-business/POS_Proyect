<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/venta/historial.css"> 
    <script src="../app/views/admin/venta/historial.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>💰 Historial de Ventas</h1>
        <a href="index.php?c=admin&a=dashboard" class="back-btn">← Volver</a>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="ventas-container">

        <!-- TABS -->
        <div class="tabs">
            <button class="tab active" data-tab="fechas">📅 Por Fechas</button>
            <button class="tab" data-tab="usuario">👤 Por Usuario</button>
            <button class="tab" data-tab="producto">📦 Por Producto</button>
        </div>

        <!-- TAB CONTENT: POR FECHAS -->
        <div class="tab-content active" id="fechas">
            <div class="filters">
                <div class="filter-group">
                    <label for="fecha_inicio">Fecha Inicio</label>
                    <input type="date" id="fecha_inicio" value="<?php echo date('Y-m-d', strtotime('-7 days')); ?>">
                </div>
                <div class="filter-group">
                    <label for="fecha_fin">Fecha Fin</label>
                    <input type="date" id="fecha_fin" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button class="btn-filter" onclick="buscarPorFechas()">🔍 Buscar</button>
                </div>
            </div>

            <div class="stats" id="stats-fechas" style="display: none;">
                <div class="stat-card">
                    <div class="stat-label">Total Ventas</div>
                    <div class="stat-value" id="total-ventas-fechas">0</div>
                </div>
                <div class="stat-card secondary">
                    <div class="stat-label">Ingresos Totales</div>
                    <div class="stat-value" id="ingresos-fechas">$0.00</div>
                </div>
            </div>

            <div class="table-container">
                <div id="range-fechas" style="margin-bottom:1rem;color:#333;font-weight:500;">&nbsp;</div>
                <div id="results-fechas" class="loading">Selecciona un rango de fechas y haz clic en Buscar</div>
            </div>
        </div>

        <!-- TAB CONTENT: POR USUARIO -->
        <div class="tab-content" id="usuario">
            <div class="filters">
                <div class="filter-group">
                    <label for="select_usuario">Seleccionar Usuario</label>
                    <select id="select_usuario">
                        <option value="">-- Seleccionar --</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?php echo $u['id']; ?>">
                                <?php echo htmlspecialchars($u['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button class="btn-filter" onclick="buscarPorUsuario()">🔍 Buscar</button>
                </div>
            </div>

            <div class="stats" id="stats-usuario" style="display: none;">
                <div class="stat-card">
                    <div class="stat-label">Total Ventas</div>
                    <div class="stat-value" id="total-ventas-usuario">0</div>
                </div>
                <div class="stat-card secondary">
                    <div class="stat-label">Ingresos Totales</div>
                    <div class="stat-value" id="ingresos-usuario">$0.00</div>
                </div>
            </div>

            <div class="table-container">
                <div id="results-usuario" class="loading">Selecciona un usuario y haz clic en Buscar</div>
            </div>
        </div>

        <!-- TAB CONTENT: POR PRODUCTO -->
        <div class="tab-content" id="producto">
            <div class="filters">
                <div class="filter-group">
                    <label for="select_producto">Seleccionar Producto</label>
                    <select id="select_producto">
                        <option value="">-- Seleccionar --</option>
                        <?php foreach ($productos as $p): ?>
                            <option value="<?php echo $p['id']; ?>">
                                <?php echo htmlspecialchars($p['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button class="btn-filter" onclick="buscarPorProducto()">🔍 Buscar</button>
                </div>
            </div>

            <div class="stats" id="stats-producto" style="display: none;">
                <div class="stat-card">
                    <div class="stat-label">Veces Vendido</div>
                    <div class="stat-value" id="total-ventas-producto">0</div>
                </div>
                <div class="stat-card secondary">
                    <div class="stat-label">Cantidad Total</div>
                    <div class="stat-value" id="cantidad-producto">0</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Ingresos Totales</div>
                    <div class="stat-value" id="ingresos-producto">$0.00</div>
                </div>
            </div>

            <div class="table-container">
                <div id="results-producto" class="loading">Selecciona un producto y haz clic en Buscar</div>
            </div>
        </div>

    </main>
</body>
</html>