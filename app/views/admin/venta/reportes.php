<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Admin</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="../app/views/admin/venta/reportes.css">
    <script src="../app/views/admin/venta/reportes.js"></script>
</head>
<body>

    <header class="admin-header">
        <h1>📊 Reportes</h1>
        <a href="index.php?c=admin&a=dashboard" class="back-btn">← Volver</a>
    </header>

    <main class="reportes-container">

        <!-- RESUMEN GENERAL -->
        <section class="section">
            <h2 class="section-title">📈 Resumen General</h2>
            <div class="resumen-grid" id="resumenGeneral">
                <div class="loading">Cargando...</div>
            </div>
        </section>

        <!-- TOP PRODUCTOS -->
        <section class="section">
            <h2 class="section-title">🏆 Top 5 Productos Más Vendidos</h2>
            <div class="chart-container">
                <canvas id="chartTopProductos"></canvas>
            </div>
        </section>

        <!-- MÉTODOS DE PAGO -->
        <section class="section">
            <h2 class="section-title">💳 Ventas por Método de Pago</h2>
            <div class="chart-grid">
                <div class="chart-container">
                    <canvas id="chartMetodosPago"></canvas>
                </div>
                <div id="metodosPagoStats"></div>
            </div>
        </section>

        <!-- RENDIMIENTO EMPLEADOS -->
        <section class="section">
            <h2 class="section-title">👥 Rendimiento por Empleado</h2>
            <div id="tablaEmpleados">
                <div class="loading">Cargando...</div>
            </div>
        </section>

    </main>
</body>
</html>