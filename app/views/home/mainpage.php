<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Sistema de Ventas</title>
    <link rel="stylesheet" href="../app/views/home/mainpage.css">
    <script src="../app/views/home/mainpage.js"></script>
</head>
<body>
    <?php
        $rol = $_SESSION['usuario']['rol'];
        $rolTexto = ($rol == 1) ? 'Admin' : 'Empleado';
    ?>
    <!-- HEADER -->
    <header class="pos-header">
        <div class="pos-user">
            <strong>Usuario:</strong> 
            <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>
            <span class="role">(<?php echo $rolTexto; ?>)</span>
        </div>

        <button class="logout-btn">Cerrar sesión</button>
    </header>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="pos-container">

        <!-- ZONA DE VENTA -->
        <section class="sale-area">
            <h2>Venta actual</h2>

            <div class="sale-list">
                <!-- Vacío inicialmente -->
                <div class="empty-cart">No hay productos en la venta</div>
            </div>

            <div class="sale-total">
                Total: <span>$0.00</span>
            </div>
        </section>

        <!-- PANEL LATERAL -->
        <aside class="side-panel">
            <h3>Acciones</h3>

            <!-- BÚSQUEDA MANUAL -->
            <div class="input-section">
                <label for="barcode">📦 Código de barras</label>
                <input 
                    type="text" 
                    id="barcode" 
                    placeholder="Ejemplo: M-0019-A"
                    autofocus
                >
                <button class="search-btn">Buscar producto</button>
            </div>

            <hr class="divider">

            <!-- MÉTODO DE PAGO -->
            <div class="payment-method">
                <label for="payment">💳 Método de pago</label>
                <select id="payment">
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                </select>
            </div>

            <hr class="divider">

            <!-- BOTONES DE ACCIÓN -->
            <button class="action-btn">💰 Cobrar</button>
            <button class="action-btn cancel">❌ Cancelar venta</button>

            <!-- SOLO ADMIN -->
             <?php if($rol == 1): ?>
                <button onclick= "location.href='index.php?c=admin&a=dashboard'" class="admin-btn">⚙️ Operaciones admin</button>
            <?php endif; ?>
        </aside>

    </main>

</body>
</html>