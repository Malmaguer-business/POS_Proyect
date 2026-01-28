document.addEventListener('DOMContentLoaded', function() {
            
            document.getElementById('productoForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                // Validaciones básicas
                const nombre = formData.get('nombre').trim();
                const precio = parseFloat(formData.get('precio'));
                const stock = parseInt(formData.get('stock'));
                const stockMinimo = parseInt(formData.get('stock_minimo'));
                const codigoBarras = formData.get('codigo_barras').trim();
                const categoriaId = formData.get('categoria_id');

                if (!nombre || !codigoBarras || !categoriaId) {
                    mostrarAlerta('Por favor completa todos los campos obligatorios', 'error');
                    return;
                }

                if (precio < 0 || stock < 0 || stockMinimo < 0) {
                    mostrarAlerta('Los valores numéricos no pueden ser negativos', 'error');
                    return;
                }

                try {
                    const response = await fetch('index.php?c=producto&a=registrar', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        mostrarAlerta('Producto creado exitosamente', 'success');
                        document.getElementById('productoForm').reset();
                    } else {
                        mostrarAlerta(data.message || 'Error al crear el producto', 'error');
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