<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/categoria/gestionar.css">
    <script src="../app/views/admin/categoria/gestionar.js"></script>
</head>
<body>
    <!-- HEADER -->
    <header class="admin-header">
        <h1>📂 Gestión de Categorías</h1>
        <a href="index.php?c=admin&a=dashboard" class="back-btn">← Volver</a>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="list-container">
        
        <div class="list-header">
            <h2>
                <span>📂</span>
                Todas las Categorías
            </h2>
            <a href="index.php?c=categoria&a=crear" class="btn-new">
                ➕ Nueva Categoría
            </a>
        </div>

        <div class="table-container">
            <?php if (empty($categorias)): ?>
                <div class="empty-state">
                    <div class="icon">📂</div>
                    <p>No hay categorías registradas</p>
                    <p><a href="index.php?c=categoria&a=crear">Crear la primera categoría</a></p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($categoria['nombre']); ?></strong>
                                </td>
                                <td>
                                    <?php 
                                        $desc = htmlspecialchars($categoria['descripcion']);
                                        echo $desc ?: '<em style="color: #999;">Sin descripción</em>'; 
                                    ?>
                                </td>
                                <td>
                                    <?php if ($categoria['estatus'] == 1): ?>
                                        <span class="badge badge-active">✓ Activa</span>
                                    <?php else: ?>
                                        <span class="badge badge-inactive">✕ Inactiva</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button 
                                            class="btn-action btn-edit" 
                                            onclick="editarCategoria('<?php echo $categoria['id']; ?>')">
                                            ✏️ Editar
                                        </button>
                                        
                                        <?php if ($categoria['estatus'] == 1): ?>
                                            <button 
                                                class="btn-action btn-toggle" 
                                                onclick="toggleCategoria('<?php echo $categoria['id']; ?>', 0)">
                                                🔒 Desactivar
                                            </button>
                                        <?php else: ?>
                                            <button 
                                                class="btn-action btn-activate" 
                                                onclick="toggleCategoria('<?php echo $categoria['id']; ?>', 1)">
                                                🔓 Activar
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </main>
</body>
</html>