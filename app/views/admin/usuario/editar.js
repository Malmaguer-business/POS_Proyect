let nuevaContraseñaGenerada = false;

        function generarNuevaContraseña() {
            // Generar contraseña aleatoria de 8 caracteres
            const caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
            let password = '';
            for (let i = 0; i < 8; i++) {
                password += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }

            // Mostrar la contraseña
            document.getElementById('passwordDisplay').textContent = password;
            document.getElementById('passwordContainer').style.display = 'flex';
            document.getElementById('resetPasswordBtn').style.display = 'none';
            document.getElementById('newPassword').value = password;
            
            nuevaContraseñaGenerada = true;

            mostrarAlerta('Nueva contraseña generada. Asegúrate de copiarla antes de guardar.', 'success');
        }

        function copiarContraseña() {
            const password = document.getElementById('passwordDisplay').textContent;
            navigator.clipboard.writeText(password).then(() => {
                const btn = event.target;
                const originalText = btn.textContent;
                btn.textContent = '✓ Copiado';
                btn.style.backgroundColor = '#28a745';
                btn.style.color = 'white';
                
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.backgroundColor = '';
                    btn.style.color = '';
                }, 2000);
            }).catch(err => {
                alert('Error al copiar la contraseña');
                console.error('Error:', err);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            
            document.getElementById('usuarioForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const id = document.querySelector('input[name="id"]').value;
                const nombre = document.getElementById('nombre').value.trim();
                const correo = document.getElementById('correo').value.trim();
                const telefono = document.getElementById('telefono').value.trim();
                const newPassword = document.getElementById('newPassword').value;

                // Validaciones
                if (!nombre || !correo || !telefono) {
                    mostrarAlerta('Por favor completa todos los campos obligatorios', 'error');
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
                    formData.append('id', id);
                    formData.append('nombre', nombre);
                    formData.append('correo', correo);
                    formData.append('telefono', telefono);
                    if (newPassword) {
                        formData.append('new_password', newPassword);
                    }

                    const response = await fetch('index.php?c=usuario&a=actualizar', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        mostrarAlerta('Usuario actualizado exitosamente', 'success');
                        setTimeout(() => {
                            location.href = 'index.php?c=usuario&a=gestionar';
                        }, 2000);
                    } else {
                        mostrarAlerta(data.message || 'Error al actualizar el usuario', 'error');
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