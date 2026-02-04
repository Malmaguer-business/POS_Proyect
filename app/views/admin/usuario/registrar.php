<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* HEADER */
        .admin-header {
            background-color: #333;
            color: white;
            padding: 0.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            font-size: 1.3rem;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        /* MAIN CONTAINER */
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eee;
        }

        .form-header .icon {
            font-size: 2rem;
        }

        .form-header h2 {
            font-size: 1.5rem;
            color: #333;
        }

        /* FORM */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
            font-size: 0.95rem;
        }

        .form-group label .required {
            color: #dc3545;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            font-family: Arial, sans-serif;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #6f42c1;
            box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1);
        }

        .form-group small {
            display: block;
            margin-top: 0.25rem;
            color: #666;
            font-size: 0.85rem;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle input {
            padding-right: 3rem;
        }

        .toggle-btn {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: #666;
        }

        .toggle-btn:hover {
            color: #333;
        }

        /* ROLE SELECTOR */
        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .role-option {
            position: relative;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .role-card {
            padding: 1.5rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .role-option input[type="radio"]:checked + .role-card {
            border-color: #6f42c1;
            background-color: #f8f5ff;
        }

        .role-card:hover {
            border-color: #6f42c1;
        }

        .role-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .role-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .role-desc {
            font-size: 0.85rem;
            color: #666;
        }

        /* BUTTONS */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #6f42c1;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5a32a3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* ALERT */
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            display: none;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert.show {
            display: block;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .form-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .role-selector {
                grid-template-columns: 1fr;
            }
        }
    </style>
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

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.addEventListener('DOMContentLoaded', function() {
            
            document.getElementById('usuarioForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const nombre = document.getElementById('nombre').value.trim();
                const correo = document.getElementById('correo').value.trim();
                const telefono = document.getElementById('telefono').value.trim();
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirm').value;
                const rol = document.querySelector('input[name="rol"]:checked').value;

                // Validaciones
                if (!nombre || !correo || !telefono || !password) {
                    mostrarAlerta('Por favor completa todos los campos obligatorios', 'error');
                    return;
                }

                if (password !== passwordConfirm) {
                    mostrarAlerta('Las contraseñas no coinciden', 'error');
                    return;
                }

                if (password.length < 6) {
                    mostrarAlerta('La contraseña debe tener al menos 6 caracteres', 'error');
                    return;
                }

                // Validar formato de correo
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(correo)) {
                    mostrarAlerta('Ingresa un correo electrónico válido', 'error');
                    return;
                }

                try {
                    const formData = new FormData();
                    formData.append('nombre', nombre);
                    formData.append('correo', correo);
                    formData.append('telefono', telefono);
                    formData.append('password', password);
                    formData.append('rol', rol);

                    const response = await fetch('index.php?c=usuario&a=registrar', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        mostrarAlerta('Usuario creado exitosamente', 'success');
                        document.getElementById('usuarioForm').reset();
                        
                        setTimeout(() => {
                            location.href = 'index.php?c=usuario&a=gestionar';
                        }, 2000);
                    } else {
                        mostrarAlerta(data.message || 'Error al crear el usuario', 'error');
                    }

                } catch (error) {
                    console.error('Error:', error);
                    mostrarAlerta('Error de conexión', 'error');
                }
            });

            function mostrarAlerta(mensaje, tipo) {
                const alert = document.getElementById('alert');
                alert.textContent = mensaje;
                alert.className = `alert ${tipo} show`;
                
                setTimeout(() => {
                    alert.classList.remove('show');
                }, 5000);
            }
            
        });
    </script>

</body>
</html>