document.addEventListener('DOMContentLoaded', function() {
    
    document.getElementById('categoriaForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.querySelector('input[name="id"]').value;
        const nombre = document.getElementById('nombre').value.trim();
        const descripcion = document.getElementById('descripcion').value.trim();

        mostrarAlerta('Procesando...', 'info');
        
        // Validación básica
        if (!nombre) {
            mostrarAlerta('El nombre de la categoría es obligatorio', 'error');
            return;
        }

        try {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('descripcion', descripcion);

            const response = await fetch('index.php?c=categoria&a=actualizar', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                mostrarAlerta('Categoría actualizada exitosamente', 'success');
                setTimeout(() => {
                    location.href = 'index.php?c=categoria&a=gestionar';
                }, 2000);
            } else {
                mostrarAlerta(data.message || 'Error al actualizar la categoría', 'error');
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