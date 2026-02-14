<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Iniciar Sesión</title>
    <link rel="stylesheet" href="../app/views/auth/login.css">
</head>
<body>
    <div class="login-container">
        <!-- SIDE PANEL CON GRADIENT -->
        <div class="login-side">
            <div class="side-content">
                <div class="logo">
                    <div class="logo-icon">🛒</div>
                    <h1>POS System</h1>
                </div>
                <p class="tagline">Sistema de Punto de Venta</p>
                <div class="features">
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Gestión de inventario</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Control de ventas</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Reportes en tiempo real</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORMULARIO DE LOGIN -->
        <div class="login-form-container">
            <div class="login-form-content">
                <h2>Iniciar Sesión</h2>
                <p class="subtitle">Ingresa tus credenciales para continuar</p>

                <?php if (isset($error)): ?>
                    <div class="alert-error">
                        <span class="alert-icon">⚠️</span>
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?c=auth&a=authenticate" class="login-form">
                    <div class="form-group">
                        <label for="correo">
                            <span class="label-icon">📧</span>
                            Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            id="correo"
                            name="correo" 
                            placeholder="ejemplo@correo.com"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <span class="label-icon">🔒</span>
                            Contraseña
                        </label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            placeholder="••••••••"
                            required
                        >
                    </div>

                    <button type="submit" class="login-btn">
                        <span>Iniciar Sesión</span>
                        <span class="btn-arrow">→</span>
                    </button>
                </form>

                <div class="login-footer">
                    <p>© 2026 POS System. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>