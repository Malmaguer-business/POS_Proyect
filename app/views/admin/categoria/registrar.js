// Validación y submit del formulario
document.getElementById('categoriaForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const nombre = document.getElementById('nombre').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();

    // Validación básica
    if (!nombre) {
        mostrarAlerta('El nombre de la categoría es obligatorio', 'error');
        return;
    }

    try {
        const formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('descripcion', descripcion);

        const response = await fetch('index.php?c=categoria&a=registrar', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            mostrarAlerta('Categoría creada exitosamente', 'success');
            // Limpiar formulario
            document.getElementById('categoriaForm').reset();
            // Opcional: redirigir después de 2 segundos
            setTimeout(() => {
                location.href = 'index.php?c=categoria&a=listar';
            }, 2000);
        } else {
            mostrarAlerta(data.message || 'Error al crear la categoría', 'error');
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
            
    // Ocultar después de 5 segundos
    setTimeout(() => {
        alert.classList.remove('show');
    }, 5000);
}