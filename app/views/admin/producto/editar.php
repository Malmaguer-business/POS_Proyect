<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Admin</title>
    <link rel="stylesheet"href="../app/views/admin/producto/editar.css">
    <script src="../app/views/admin/producto/editar.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>📦 Editar Producto</h1>
        <a href="index.php?c=producto&a=gestionar" class="back-btn">← Volver</a>
    </header>

    <!-- FORM CONTAINER -->
    <main class="form-container">
        
        <div class="form-header">
            <span class="icon">✏️</span>
            <h2>Modificar Producto</h2>
        </div>

        <!-- FORM -->
        <form id="productoForm" method="POST">
            
            <div class="form-grid">
                <!-- ALERT -->
                <div id="alert" class="alert"></div>

                <!-- INFO BOX -->
                <div class="info-box">
                    <strong>Nota:</strong> El stock actual se gestiona desde la opción "Ajustar Stock". Aquí solo se modifica la información básica del producto.
                </div>

                <!-- Campo oculto con el ID -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">

                <!-- NOMBRE -->
                <div class="form-group">
                    <label for="nombre">
                        Nombre del producto <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        placeholder="Ej: Coca Cola 600ml"
                        value="<?php echo htmlspecialchars($producto['nombre']); ?>"
                        required
                        maxlength="50"
                        autofocus
                    >
                    <small>Máximo 50 caracteres</small>
                </div>

                <!-- CÓDIGO DE BARRAS (Solo lectura) -->
                <div class="form-group">
                    <label for="codigo_barras">
                        Código de barras
                    </label>
                    <input 
                        type="text" 
                        id="codigo_barras" 
                        value="<?php echo htmlspecialchars($producto['codigo_barras']); ?>"
                        readonly
                        style="background-color: #f8f9fa; cursor: not-allowed;"
                    >
                    <small>No se puede modificar</small>
                </div>

                <!-- PRECIO -->
                <div class="form-group">
                    <label for="precio">
                        Precio <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="precio" 
                        name="precio" 
                        placeholder="0.00"
                        value="<?php echo htmlspecialchars($producto['precio']); ?>"
                        step="0.01"
                        min="0"
                        required
                    >
                    <small>En pesos mexicanos</small>
                </div>

                <!-- CATEGORÍA -->
                <div class="form-group">
                    <label for="categoria_id">
                        Categoría <span class="required">*</span>
                    </label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo htmlspecialchars($categoria['id']); ?>"
                                <?php echo ($categoria['id'] == $producto['categoria_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- STOCK MÍNIMO -->
                <div class="form-group full-width">
                    <label for="stock_minimo">
                        Stock mínimo <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="stock_minimo" 
                        name="stock_minimo" 
                        placeholder="0"
                        value="<?php echo htmlspecialchars($producto['stock_minimo']); ?>"
                        min="0"
                        required
                    >
                    <small>Alerta cuando el stock llegue a este nivel</small>
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="form-group full-width">
                    <label for="descripcion">
                        Descripción
                    </label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        placeholder="Descripción opcional del producto"
                    ><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                    <small>Opcional</small>
                </div>

                <!-- URL DE IMAGEN -->
                <div class="form-group full-width">
                    <label for="imagen_url">
                        URL de imagen
                    </label>
                    <input 
                        type="url" 
                        id="imagen_url" 
                        name="imagen_url" 
                        placeholder="https://ejemplo.com/imagen.jpg"
                        value="<?php echo htmlspecialchars($producto['imagen_url']); ?>"
                        maxlength="500"
                    >
                    <small>Opcional - URL de la imagen del producto</small>
                </div>

                <!-- BOTONES -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        ✓ Guardar Cambios
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='index.php?c=producto&a=gestionar'">
                        ✕ Cancelar
                    </button>
                </div>
            </div>

        </form>

    </main>
</body>
</html>