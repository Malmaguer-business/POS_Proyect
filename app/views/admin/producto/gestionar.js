        document.addEventListener('DOMContentLoaded', function() {
            // FILTROS
            const filterButtons = document.querySelectorAll('.filter-btn');
            const tableRows = document.querySelectorAll('#productosTable tbody tr');

            filterButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Actualizar botón activo
                    filterButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const filter = this.dataset.filter;

                    // Filtrar filas
                    tableRows.forEach(row => {
                        const estatus = row.dataset.estatus;
                        
                        if (filter === 'all') {
                            row.style.display = '';
                        } else if (filter === 'active' && estatus === '1') {
                            row.style.display = '';
                        } else if (filter === 'inactive' && estatus === '0') {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });
        });

        function editarProducto(id) {
            window.location.href = `index.php?c=producto&a=editar&id=${id}`;
        }

        function ajustarStock(id) {
            window.location.href = `index.php?c=producto&a=ajustarStock&id=${id}`;
        }

        async function toggleProducto(id, nuevoEstatus) {
            const accion = nuevoEstatus === 1 ? 'activar' : 'desactivar';
            
            if (!confirm(`¿Estás seguro de ${accion} este producto?`)) {
                return;
            }

            try {
                const response = await fetch('index.php?c=producto&a=toggleEstatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&estatus=${nuevoEstatus}`
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message || 'Error al actualizar el producto');
                }

            } catch (error) {
                console.error('Error:', error);
                alert('Error de conexión');
            }
        }