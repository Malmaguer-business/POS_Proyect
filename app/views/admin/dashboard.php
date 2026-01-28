<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sistema POS</title>
    <link rel="stylesheet" href="../app/views/admin/dashboard.css">
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>⚙️ Operaciones Admin</h1>
        <a href="index.php?c=home&a=main" class="back-btn">← Volver al POS</a>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="admin-container">

        <!-- SECCIÓN PRODUCTOS -->
        <section class="admin-section">
            <div class="section-header">
                <span class="icon">📦</span>
                <h2>PRODUCTOS</h2>
            </div>
            <div class="button-grid">
                <button class="admin-btn btn-productos" onclick="location.href='index.php?c=producto&a=crear'">
                    <span class="btn-icon">➕</span>
                    <span class="btn-text">Agregar</span>
                </button>
                <button class="admin-btn btn-productos" onclick="location.href='index.php?c=producto&a=gestionar'">
                    <span class="btn-icon">📋</span>
                    <span class="btn-text">Ver todos</span>
                </button>
                <button class="admin-btn btn-productos" onclick="location.href='index.php?c=producto&a=editar'">
                    <span class="btn-icon">✏️</span>
                    <span class="btn-text">Editar</span>
                </button>
                <button class="admin-btn btn-productos" onclick="location.href='index.php?c=producto&a=eliminar'">
                    <span class="btn-icon">🗑️</span>
                    <span class="btn-text">Eliminar</span>
                </button>
                <button class="admin-btn btn-productos" onclick="location.href='index.php?c=producto&a=ajustarStock'">
                    <span class="btn-icon">📊</span>
                    <span class="btn-text">Ajustar Stock</span>
                </button>
            </div>
        </section>

        <!-- SECCIÓN CATEGORÍAS -->
        <section class="admin-section">
            <div class="section-header">
                <span class="icon">📂</span>
                <h2>CATEGORÍAS</h2>
            </div>
            <div class="button-grid">
                <button class="admin-btn btn-categorias" onclick="location.href='index.php?c=categoria&a=crear'">
                    <span class="btn-icon">➕</span>
                    <span class="btn-text">Crear</span>
                </button>
                <button class="admin-btn btn-categorias" onclick="location.href='index.php?c=categoria&a=gestionar'">
                    <span class="btn-icon">📋</span>
                    <span class="btn-text">Ver todas</span>
                </button>
            </div>
        </section>

        <!-- SECCIÓN USUARIOS -->
        <section class="admin-section">
            <div class="section-header">
                <span class="icon">👥</span>
                <h2>USUARIOS</h2>
            </div>
            <div class="button-grid">
                <button class="admin-btn btn-usuarios" onclick="location.href='index.php?c=usuario&a=crear'">
                    <span class="btn-icon">➕</span>
                    <span class="btn-text">Registrar</span>
                </button>
                <button class="admin-btn btn-usuarios" onclick="location.href='index.php?c=usuario&a=listar'">
                    <span class="btn-icon">📋</span>
                    <span class="btn-text">Ver todos</span>
                </button>
                <button class="admin-btn btn-usuarios" onclick="location.href='index.php?c=usuario&a=editar'">
                    <span class="btn-icon">✏️</span>
                    <span class="btn-text">Editar</span>
                </button>
                <button class="admin-btn btn-usuarios" onclick="location.href='index.php?c=usuario&a=eliminar'">
                    <span class="btn-icon">🗑️</span>
                    <span class="btn-text">Eliminar</span>
                </button>
                <button class="admin-btn btn-usuarios" onclick="location.href='index.php?c=usuario&a=miPerfil'">
                    <span class="btn-icon">👤</span>
                    <span class="btn-text">Mi Perfil</span>
                </button>
            </div>
        </section>

        <!-- SECCIÓN VENTAS -->
        <section class="admin-section">
            <div class="section-header">
                <span class="icon">💰</span>
                <h2>VENTAS</h2>
            </div>
            <div class="button-grid">
                <button class="admin-btn btn-ventas" onclick="location.href='index.php?c=venta&a=historial'">
                    <span class="btn-icon">📜</span>
                    <span class="btn-text">Historial</span>
                </button>
                <button class="admin-btn btn-ventas" onclick="location.href='index.php?c=venta&a=reportes'">
                    <span class="btn-icon">📊</span>
                    <span class="btn-text">Reportes</span>
                </button>
                <button class="admin-btn btn-ventas" onclick="location.href='index.php?c=venta&a=detalles'">
                    <span class="btn-icon">🔍</span>
                    <span class="btn-text">Ver Detalles</span>
                </button>
            </div>
        </section>

    </main>

</body>
</html>