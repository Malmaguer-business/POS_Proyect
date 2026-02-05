<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/usuario/gestionar.css">
    <script src="../app/views/admin/usuario/gestionar.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>👥 Gestión de Usuarios</h1>
        <a href="index.php?c=admin&a=dashboard" class="back-btn">← Volver</a>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="list-container">
        
        <div class="list-header">
            <h2>
                <span>👥</span>
                Todos los Usuarios
            </h2>
            <div class="header-actions">
                <div class="filter-toggle">
                    <button class="filter-btn active" data-filter="all">Todos</button>
                    <button class="filter-btn" data-filter="active">Activos</button>
                    <button class="filter-btn" data-filter="inactive">Inactivos</button>
                </div>
                <a href="index.php?c=usuario&a=crear" class="btn-new">
                    ➕ Nuevo Usuario
                </a>
            </div>
        </div>

        <div class="table-container">
            <?php if (empty($usuarios)): ?>
                <div class="empty-state">
                    <div class="icon">👥</div>
                    <p>No hay usuarios registrados</p>
                    <p><a href="index.php?c=usuario&a=crear">Crear el primer usuario</a></p>
                </div>
            <?php else: ?>
                <table id="usuariosTable">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr data-estatus="<?php echo $usuario['estatus']; ?>">
                                <td>
                                    <div class="user-info">
                                        <div class="user-name">
                                            <?php echo htmlspecialchars($usuario['nombre']); ?>
                                        </div>
                                        <div class="user-email">
                                            <?php echo htmlspecialchars($usuario['correo']); ?>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                                <td>
                                    <?php if ($usuario['rol'] == 1): ?>
                                        <span class="role-badge role-admin">👑 Admin</span>
                                    <?php else: ?>
                                        <span class="role-badge role-empleado">👤 Empleado</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($usuario['estatus'] == 1): ?>
                                        <span class="badge badge-active">✓ Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-inactive">✕ Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                        $fecha = new DateTime($usuario['fecha_creacion']);
                                        echo $fecha->format('d/m/Y'); 
                                    ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button 
                                            class="btn-action btn-edit" 
                                            onclick="editarUsuario('<?php echo $usuario['id']; ?>')">
                                            ✏️ Editar
                                        </button>
                                        
                                        <?php if ($usuario['estatus'] == 1): ?>
                                            <button 
                                                class="btn-action btn-toggle" 
                                                onclick="toggleUsuario('<?php echo $usuario['id']; ?>', 0)">
                                                🔒 Desactivar
                                            </button>
                                        <?php else: ?>
                                            <button 
                                                class="btn-action btn-activate" 
                                                onclick="toggleUsuario('<?php echo $usuario['id']; ?>', 1)">
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