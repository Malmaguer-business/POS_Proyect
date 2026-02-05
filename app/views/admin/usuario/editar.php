<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/usuario/editar.css">
    <script src="../app/views/admin/usuario/editar.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>👥 Editar Usuario</h1>
        <a href="index.php?c=usuario&a=gestionar" class="back-btn">← Volver</a>
    </header>

    <!-- FORM CONTAINER -->
    <main class="form-container">
        
        <div class="form-header">
            <span class="icon">✏️</span>
            <h2>Modificar Usuario</h2>
        </div>

        <!-- ALERT -->
        <div id="alert" class="alert"></div>

        <!-- FORM -->
        <form id="usuarioForm" method="POST">
            
            <!-- Campo oculto con el ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">

            <!-- NOMBRE -->
            <div class="form-group">
                <label for="nombre">
                    Nombre completo <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    placeholder="Ej: Juan Pérez García"
                    value="<?php echo htmlspecialchars($usuario['nombre']); ?>"
                    required
                    maxlength="50"
                    autofocus
                >
                <small>Máximo 50 caracteres</small>
            </div>

            <!-- CORREO -->
            <div class="form-group">
                <label for="correo">
                    Correo electrónico <span class="required">*</span>
                </label>
                <input 
                    type="email" 
                    id="correo" 
                    name="correo" 
                    placeholder="ejemplo@correo.com"
                    value="<?php echo htmlspecialchars($usuario['correo']); ?>"
                    required
                    maxlength="50"
                >
                <small>Se usa para iniciar sesión</small>
            </div>

            <!-- TELÉFONO -->
            <div class="form-group">
                <label for="telefono">
                    Teléfono <span class="required">*</span>
                </label>
                <input 
                    type="tel" 
                    id="telefono" 
                    name="telefono" 
                    placeholder="8112345678"
                    value="<?php echo htmlspecialchars($usuario['telefono']); ?>"
                    required
                    maxlength="20"
                >
                <small>10 dígitos sin espacios</small>
            </div>

            <!-- CONTRASEÑA -->
            <div class="form-group">
                <label>
                    Contraseña
                </label>
                <div class="password-display" id="passwordContainer" style="display: none;">
                    <span class="password-value" id="passwordDisplay"></span>
                    <button type="button" class="copy-btn" onclick="copiarContraseña()">
                        📋 Copiar
                    </button>
                </div>
                <button type="button" class="copy-btn" id="resetPasswordBtn" onclick="generarNuevaContraseña()" style="width: 100%;">
                    🔑 Generar Nueva Contraseña
                </button>
                <div class="password-note">
                    <strong>Nota:</strong> Las contraseñas están encriptadas por seguridad. Haz clic en "Generar Nueva Contraseña" para crear una nueva y poder compartirla con el empleado.
                </div>
            </div>

            <!-- Campo oculto para la nueva contraseña -->
            <input type="hidden" id="newPassword" name="new_password" value="">

            <!-- BOTONES -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    ✓ Guardar Cambios
                </button>
                <button type="button" class="btn btn-secondary" onclick="location.href='index.php?c=usuario&a=gestionar'">
                    ✕ Cancelar
                </button>
            </div>

        </form>

    </main>

</body>
</html>