<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Venta - Admin</title>
    <link rel="stylesheet" href="../app/views/admin/venta/detalles.css">
    <script src="../app/views/admin/venta/detalles.js"></script>
</head>
<body>

    <!-- HEADER -->
    <header class="admin-header">
        <h1>🧾 Detalles de Venta</h1>
        <a href="index.php?c=venta&a=historial" class="back-btn">← Volver al Historial</a>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="detalles-container">
        <div id="loading" class="loading">
            <div class="spinner"></div>
            <p>Cargando detalles...</p>
        </div>

        <div id="content" style="display: none;">
            <!-- INFORMACIÓN DE LA VENTA -->
            <section class="info-section">
                <h2 class="section-title">📋 Información de la Venta</h2>
                <div class="info-grid" id="infoVenta">
                    <!-- Se llenará dinámicamente -->
                </div>
            </section>

            <!-- PRODUCTOS DE LA VENTA -->
            <section class="productos-section">
                <h2 class="section-title">🛒 Productos Vendidos</h2>
                <div class="table-container">
                    <table id="tablaProductos">
                        <!-- Se llenará dinámicamente -->
                    </table>
                </div>
            </section>

            <!-- RESUMEN TOTAL -->
            <section class="total-section">
                <div class="total-box">
                    <div class="total-label">TOTAL DE LA VENTA</div>
                    <div class="total-amount" id="totalVenta">$0.00</div>
                </div>
            </section>

            <!-- BOTONES DE ACCIÓN -->
            <section class="actions-section">
                <button class="btn-action btn-print" onclick="imprimirTicket()">
                    🖨️ Imprimir Ticket
                </button>
                <button class="btn-action btn-secondary" onclick="window.location.href='index.php?c=venta&a=historial'">
                    📋 Volver al Historial
                </button>
            </section>
        </div>

        <!-- ERROR STATE -->
        <div id="error" style="display: none;" class="error-state">
            <div class="error-icon">⚠️</div>
            <p class="error-message">No se pudo cargar la información de la venta</p>
            <button class="btn-action" onclick="window.location.href='index.php?c=venta&a=historial'">
                Volver al Historial
            </button>
        </div>
    </main>

</body>
</html>