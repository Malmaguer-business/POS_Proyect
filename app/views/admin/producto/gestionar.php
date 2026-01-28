<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/producto/gestionar.css">
    <script src="../app/views/admin/producto/gestionar.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>📦 Gestión de Productos</h1>
        <a href="index.php?c=admin&a=dashboard" class="back-btn">← Volver</a>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="list-container">
        
        <div class="list-header">
            <h2>
                <span>📦</span>
                Todos los Productos
            </h2>
            <div class="header-actions">
                <div class="filter-toggle">
                    <button class="filter-btn active" data-filter="all">Todos</button>
                    <button class="filter-btn" data-filter="active">Activos</button>
                    <button class="filter-btn" data-filter="inactive">Inactivos</button>
                </div>
                <a href="index.php?c=producto&a=crear" class="btn-new">
                    ➕ Nuevo Producto
                </a>
            </div>
        </div>

        <div class="table-container">
            <?php if (empty($productos)): ?>
                <div class="empty-state">
                    <div class="icon">📦</div>
                    <p>No hay productos registrados</p>
                    <p><a href="index.php?c=producto&a=crear">Crear el primer producto</a></p>
                </div>
            <?php else: ?>
                <table id="productosTable">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr data-estatus="<?php echo $producto['estatus']; ?>">
                                <td>
                                    <div class="product-info">
                                        <div>
                                            <div class="product-name">
                                                <?php echo htmlspecialchars($producto['nombre']); ?>
                                            </div>
                                            <div class="product-code">
                                                <?php echo htmlspecialchars($producto['codigo_barras']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($producto['categoria_nombre'] ?? 'Sin categoría'); ?></td>
                                <td>
                                    <span class="price">$<?php echo number_format($producto['precio'], 2); ?></span>
                                </td>
                                <td>
                                    <div class="stock-cell">
                                        <span class="stock-value <?php echo ($producto['stock'] <= $producto['stock_minimo']) ? 'stock-warning' : 'stock-ok'; ?>">
                                            <?php echo $producto['stock']; ?> unidades
                                        </span>
                                        <span class="stock-min">
                                            Min: <?php echo $producto['stock_minimo']; ?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($producto['estatus'] == 1): ?>
                                        <span class="badge badge-active">✓ Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-inactive">✕ Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button 
                                            class="btn-action btn-edit" 
                                            onclick="editarProducto('<?php echo $producto['id']; ?>')">
                                            ✏️ Editar
                                        </button>
                                        
                                        <button 
                                            class="btn-action btn-stock" 
                                            onclick="ajustarStock('<?php echo $producto['id']; ?>')">
                                            📊 Stock
                                        </button>
                                        
                                        <?php if ($producto['estatus'] == 1): ?>
                                            <button 
                                                class="btn-action btn-toggle" 
                                                onclick="toggleProducto('<?php echo $producto['id']; ?>', 0)">
                                                🔒 Desactivar
                                            </button>
                                        <?php else: ?>
                                            <button 
                                                class="btn-action btn-activate" 
                                                onclick="toggleProducto('<?php echo $producto['id']; ?>', 1)">
                                                🔓 Activar
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </main>
</body>
</html>