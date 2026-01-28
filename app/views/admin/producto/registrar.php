<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/producto/registrar.css">
    <script src="../app/views/admin/producto/registrar.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>📦 Crear Producto</h1>
        <a href="index.php?c=admin&a=dashboard" class="back-btn">← Volver</a>
    </header>

    <!-- FORM CONTAINER -->
    <main class="form-container">
        
        <div class="form-header">
            <span class="icon">📦</span>
            <h2>Nuevo Producto</h2>
        </div>

        <!-- FORM -->
        <form id="productoForm" method="POST">
            
            <div class="form-grid">
                <!-- ALERT -->
                <div id="alert" class="alert"></div>

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
                        required
                        maxlength="50"
                        autofocus
                    >
                    <small>Máximo 50 caracteres</small>
                </div>

                <!-- CÓDIGO DE BARRAS -->
                <div class="form-group">
                    <label for="codigo_barras">
                        Código de barras <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="codigo_barras" 
                        name="codigo_barras" 
                        placeholder="M-0001-A"
                        required
                        maxlength="50"
                    >
                    <small>Formato: M-####-L</small>
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
                            <option value="<?php echo htmlspecialchars($categoria['id']); ?>">
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- STOCK INICIAL -->
                <div class="form-group">
                    <label for="stock">
                        Stock inicial <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="stock" 
                        name="stock" 
                        placeholder="0"
                        min="0"
                        required
                    >
                    <small>Cantidad en inventario</small>
                </div>

                <!-- STOCK MÍNIMO -->
                <div class="form-group">
                    <label for="stock_minimo">
                        Stock mínimo <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="stock_minimo" 
                        name="stock_minimo" 
                        placeholder="0"
                        min="0"
                        required
                    >
                    <small>Alerta cuando llegue a este nivel</small>
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
                    ></textarea>
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
                        maxlength="500"
                    >
                    <small>Opcional - URL de la imagen del producto</small>
                </div>

                <!-- BOTONES -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        ✓ Crear Producto
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='index.php?c=admin&a=dashboard'">
                        ✕ Cancelar
                    </button>
                </div>
            </div>

        </form>

    </main>

</body>
</html>