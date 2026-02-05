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