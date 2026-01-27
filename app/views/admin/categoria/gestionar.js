function editarCategoria(id) {
    window.location.href = `index.php?c=categoria&a=editar&id=${id}`;
}

async function toggleCategoria(id, nuevoEstatus) {
    const accion = nuevoEstatus === 1 ? 'activar' : 'desactivar';
            
    if (!confirm(`¿Estás seguro de ${accion} esta categoría?`)) {
        return;
    }

    try {
        const response = await fetch('index.php?c=categoria&a=toggleEstatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&estatus=${nuevoEstatus}`
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            location.reload(); // Recargar la página para ver los cambios
        } else {
            alert(data.message || 'Error al actualizar la categoría');
        }

    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    }
}