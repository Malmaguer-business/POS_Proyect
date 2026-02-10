<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/usuario/registrar.css">
    <script src="../app/views/admin/usuario/registrar.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>👥 Registrar Usuario</h1>
        <a href="index.php?c=admin&a=dashboard" class="back-btn">← Volver</a>
    </header>

    <!-- FORM CONTAINER -->
    <main class="form-container">
        
        <div class="form-header">
            <span class="icon">👥</span>
            <h2>Nuevo Usuario</h2>
        </div>

        <!-- ALERT -->
        <div id="alert" class="alert"></div>

        <!-- FORM -->
        <form id="usuarioForm" method="POST">
            
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
                    required
                    maxlength="50"
                >
                <small>Se usará para iniciar sesión</small>
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
                    required
                    maxlength="20"
                >
                <small>10 dígitos sin espacios</small>
            </div>

            <!-- CONTRASEÑA -->
            <div class="form-group">
                <label for="password">
                    Contraseña <span class="required">*</span>
                </label>
                <div class="password-toggle">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                        minlength="6"
                    >
                    <button type="button" class="toggle-btn" onclick="togglePassword('password')">
                        👁️
                    </button>
                </div>
                <small>Mínimo 6 caracteres</small>
            </div>

            <!-- CONFIRMAR CONTRASEÑA -->
            <div class="form-group">
                <label for="password_confirm">
                    Confirmar contraseña <span class="required">*</span>
                </label>
                <div class="password-toggle">
                    <input 
                        type="password" 
                        id="password_confirm" 
                        name="password_confirm" 
                        placeholder="••••••••"
                        required
                        minlength="6"
                    >
                    <button type="button" class="toggle-btn" onclick="togglePassword('password_confirm')">
                        👁️
                    </button>
                </div>
            </div>

            <!-- ROL -->
            <div class="form-group">
                <label>
                    Rol del usuario <span class="required">*</span>
                </label>
                <div class="role-selector">
                    <div class="role-option">
                        <input type="radio" name="rol" value="0" id="rol_empleado" checked>
                        <label for="rol_empleado" class="role-card">
                            <div class="role-icon">👤</div>
                            <div class="role-name">Empleado</div>
                            <div class="role-desc">Solo puede realizar ventas</div>
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="rol" value="1" id="rol_admin">
                        <label for="rol_admin" class="role-card">
                            <div class="role-icon">👑</div>
                            <div class="role-name">Administrador</div>
                            <div class="role-desc">Acceso completo al sistema</div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    ✓ Crear Usuario
                </button>
                <button type="button" class="btn btn-secondary" onclick="location.href='index.php?c=admin&a=dashboard'">
                    ✕ Cancelar
                </button>
            </div>

        </form>

    </main>

</body>
</html>