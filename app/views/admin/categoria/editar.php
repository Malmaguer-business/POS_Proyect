<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/categoria/editar.css">
    <script src="../app/views/admin/categoria/editar.js"></script>
</head>
<body>
    <!-- HEADER -->
    <header class="admin-header">
        <h1>📂 Editar Categoría</h1>
        <a href="index.php?c=categoria&a=gestionar" class="back-btn">← Volver</a>
    </header>

    <!-- FORM CONTAINER -->
    <main class="form-container">
        
        <div class="form-header">
            <span class="icon">✏️</span>
            <h2>Modificar Categoría</h2>
        </div>

        <!-- ALERT -->
        <div id="alert" class="alert"></div>

        <!-- FORM -->
        <form id="categoriaForm" method="POST">
            
            <!-- Campo oculto con el ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($categoria['id']); ?>">
            
            <div class="form-group">
                <label for="nombre">
                    Nombre de la categoría <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    placeholder="Ej: Bebidas, Snacks, Lácteos"
                    value="<?php echo htmlspecialchars($categoria['nombre']); ?>"
                    required
                    maxlength="255"
                    autofocus
                >
                <small>Máximo 255 caracteres</small>
            </div>

            <div class="form-group">
                <label for="descripcion">
                    Descripción
                </label>
                <textarea 
                    id="descripcion" 
                    name="descripcion" 
                    placeholder="Descripción opcional de la categoría"
                    maxlength="500"
                ><?php echo htmlspecialchars($categoria['descripcion']); ?></textarea>
                <small>Opcional - Máximo 500 caracteres</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    ✓ Guardar Cambios
                </button>
                <button type="button" class="btn btn-secondary" onclick="location.href='index.php?c=categoria&a=gestionar'">
                    ✕ Cancelar
                </button>
            </div>

        </form>

    </main>
</body>
</html>