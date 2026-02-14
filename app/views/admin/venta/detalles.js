// Obtener ID de la venta desde la URL
const urlParams = new URLSearchParams(window.location.search);
const ventaId = urlParams.get('id');

// Cargar detalles al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    if (ventaId) {
        cargarDetallesVenta(ventaId);
    } else {
        mostrarError();
    }
});

// CARGAR DETALLES DE LA VENTA
async function cargarDetallesVenta(id) {
    try {
        const response = await fetch(`index.php?c=venta&a=obtenerDetallesVenta&id=${id}`);
        const data = await response.json();

        if (data.success && data.venta && data.detalles) {
            mostrarInformacionVenta(data.venta);
            mostrarProductos(data.detalles);
            document.getElementById('loading').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        } else {
            mostrarError();
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError();
    }
}

// MOSTRAR INFORMACIÓN DE LA VENTA
function mostrarInformacionVenta(venta) {
    const fecha = new Date(venta.fecha);
    const fechaFormateada = fecha.toLocaleDateString('es-MX', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
    const horaFormateada = fecha.toLocaleTimeString('es-MX', {
        hour: '2-digit',
        minute: '2-digit'
    });

    const metodoBadge = venta.metodo_paga === 'efectivo' ? 'payment-efectivo' : 'payment-tarjeta';
    const metodoIcono = venta.metodo_paga === 'efectivo' ? '💵' : '💳';

    const html = `
        <div class="info-card">
            <div class="info-label">ID de Venta</div>
            <div class="info-value">#${venta.id.substring(0, 8)}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Fecha</div>
            <div class="info-value">${fechaFormateada}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Hora</div>
            <div class="info-value">${horaFormateada}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Empleado</div>
            <div class="info-value">${venta.usuario_nombre || 'Desconocido'}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Método de Pago</div>
            <div class="info-value">
                <span class="payment-badge ${metodoBadge}">
                    ${metodoIcono} ${venta.metodo_paga}
                </span>
            </div>
        </div>
        <div class="info-card highlight">
            <div class="info-label">Total</div>
            <div class="info-value total-highlight">$${parseFloat(venta.total).toFixed(2)}</div>
        </div>
    `;

    document.getElementById('infoVenta').innerHTML = html;
    document.getElementById('totalVenta').textContent = `$${parseFloat(venta.total).toFixed(2)}`;
}

// MOSTRAR PRODUCTOS
function mostrarProductos(detalles) {
    let html = `
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
    `;

    detalles.forEach((detalle, index) => {
        html += `
            <tr>
                <td class="numero">${index + 1}</td>
                <td class="producto-nombre">
                    <strong>${detalle.nombre_producto}</strong>
                </td>
                <td class="cantidad">${detalle.cantidad} ${detalle.cantidad > 1 ? 'unidades' : 'unidad'}</td>
                <td class="precio">$${parseFloat(detalle.precio_unitario).toFixed(2)}</td>
                <td class="subtotal">$${parseFloat(detalle.subtotal).toFixed(2)}</td>
            </tr>
        `;
    });

    html += '</tbody>';
    document.getElementById('tablaProductos').innerHTML = html;
}

// MOSTRAR ERROR
function mostrarError() {
    document.getElementById('loading').style.display = 'none';
    document.getElementById('content').style.display = 'none';
    document.getElementById('error').style.display = 'block';
}

// IMPRIMIR TICKET
function imprimirTicket() {
    window.print();
}