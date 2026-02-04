<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* HEADER */
        .admin-header {
            background-color: #333;
            color: white;
            padding: 0.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            font-size: 1.3rem;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        /* MAIN CONTAINER */
        .list-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .list-header {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .list-header h2 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            color: #333;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-new {
            background-color: #6f42c1;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }

        .btn-new:hover {
            background-color: #5a32a3;
        }

        .filter-toggle {
            display: flex;
            gap: 0.5rem;
        }

        .filter-btn {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .filter-btn.active {
            background-color: #6f42c1;
            color: white;
            border-color: #6f42c1;
        }

        /* TABLE */
        .table-container {
            background-color: white;
            border-radius: 0 0 8px 8px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f8f9fa;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* USER INFO */
        .user-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .user-name {
            font-weight: 500;
            color: #333;
        }

        .user-email {
            color: #666;
            font-size: 0.85rem;
        }

        /* ROLE BADGE */
        .role-badge {
            display: inline-block;
            padding: 0.35rem 0.85rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .role-admin {
            background-color: #f8e5ff;
            color: #6f42c1;
        }

        .role-empleado {
            background-color: #e7f3ff;
            color: #0056b3;
        }

        /* STATUS BADGE */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-active {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* ACTION BUTTONS */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        .btn-toggle {
            background-color: #6c757d;
            color: white;
        }

        .btn-toggle:hover {
            background-color: #5a6268;
        }

        .btn-activate {
            background-color: #28a745;
            color: white;
        }

        .btn-activate:hover {
            background-color: #218838;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .empty-state .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .list-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FILTROS
            const filterButtons = document.querySelectorAll('.filter-btn');
            const tableRows = document.querySelectorAll('#usuariosTable tbody tr');

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

        function editarUsuario(id) {
            window.location.href = `index.php?c=usuario&a=editar&id=${id}`;
        }

        async function toggleUsuario(id, nuevoEstatus) {
            const accion = nuevoEstatus === 1 ? 'activar' : 'desactivar';
            
            if (!confirm(`¿Estás seguro de ${accion} este usuario?`)) {
                return;
            }

            try {
                const response = await fetch('index.php?c=usuario&a=toggleEstatus', {
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
                    alert(data.message || 'Error al actualizar el usuario');
                }

            } catch (error) {
                console.error('Error:', error);
                alert('Error de conexión');
            }
        }
    </script>

</body>
</html>