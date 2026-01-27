<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/categoria/registrar.css">
    <script src="../app/views/admin/categoria/registrar.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>📂 Crear Categoría</h1>
        <a href="index.php?c=admin&a=dashboard" class="back-btn">← Volver</a>
    </header>

    <!-- FORM CONTAINER -->
    <main class="form-container">
        
        <div class="form-header">
            <span class="icon">📂</span>
            <h2>Nueva Categoría</h2>
        </div>

        <!-- ALERT -->
        <div id="alert" class="alert"></div>

        <!-- FORM -->
        <form id="categoriaForm" method="POST" action="index.php?c=categoria&a=registrar">
            
            <div class="form-group">
                <label for="nombre">
                    Nombre de la categoría <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    placeholder="Ej: Bebidas, Snacks, Lácteos"
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
                ></textarea>
                <small>Opcional - Máximo 500 caracteres</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    ✓ Crear Categoría
                </button>
                <button type="button" class="btn btn-secondary" onclick="location.href='index.php?c=admin&a=dashboard'">
                    ✕ Cancelar
                </button>
            </div>

        </form>

    </main>
</body>
</html>