document.addEventListener('DOMContentLoaded', function() {
            
            document.getElementById('productoForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const id = document.querySelector('input[name="id"]').value;
                const nombre = document.getElementById('nombre').value.trim();
                const descripcion = document.getElementById('descripcion').value.trim();
                const precio = parseFloat(document.getElementById('precio').value);
                const stockMinimo = parseInt(document.getElementById('stock_minimo').value);
                const imagenUrl = document.getElementById('imagen_url').value.trim();
                const categoriaId = document.getElementById('categoria_id').value;

                // Validaciones básicas
                if (!nombre || !categoriaId) {
                    mostrarAlerta('Por favor completa todos los campos obligatorios', 'error');
                    return;
                }

                if (precio < 0 || stockMinimo < 0) {
                    mostrarAlerta('Los valores numéricos no pueden ser negativos', 'error');
                    return;
                }

                try {
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('nombre', nombre);
                    formData.append('descripcion', descripcion);
                    formData.append('precio', precio);
                    formData.append('stock_minimo', stockMinimo);
                    formData.append('imagen_url', imagenUrl);
                    formData.append('categoria_id', categoriaId);

                    const response = await fetch('index.php?c=producto&a=actualizar', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        mostrarAlerta('Producto actualizado exitosamente', 'success');
                        setTimeout(() => {
                            location.href = 'index.php?c=producto&a=gestionar';
                        }, 2000);
                    } else {
                        mostrarAlerta(data.message || 'Error al actualizar el producto', 'error');
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