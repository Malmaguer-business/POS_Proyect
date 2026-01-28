let carrito = [];

document.addEventListener("DOMContentLoaded", function() {
    const barcodeInput = document.getElementById('barcode');
    // Auto-búsqueda al completar formato (M-####-L)
    barcodeInput.addEventListener('input', function(e) {
        const valor = this.value.trim().toUpperCase();
        // Patrón: Letra-guión-4dígitos-guión-Letra
        const patron = /^[A-Z]-\d{4}-[A-Z]$/;
                
        if (patron.test(valor)) {
            buscarProductoPorCodigo(valor);
            this.value = '';
        }
    });

    barcodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const codigo = this.value.trim();
            if (codigo) {
                buscarProductoPorCodigo(codigo);
                this.value = '';
            }
        }
    });

    document.querySelector('.search-btn').addEventListener('click', function() {
        const codigo = barcodeInput.value.trim();
        if (codigo) {
            buscarProductoPorCodigo(codigo);
            barcodeInput.value = '';
        }
        barcodeInput.focus();
    });

    // Event listener para botón Cobrar
    document.querySelector('.action-btn').addEventListener('click', function() {
        if (carrito.length === 0) {
            alert('No hay productos en el carrito');
            return;
        }
        procesarVenta();
    });

    // Event listener para botón Cancelar
    document.querySelector('.action-btn.cancel').addEventListener('click', function() {
        if (carrito.length === 0) {
            alert('No hay productos para cancelar');
            return;
        }
                
        if (confirm('¿Estás seguro de cancelar esta venta?')) {
            cancelarVenta();
        }
    });
});

// ============================================
        // FUNCIÓN DE BÚSQUEDA
        // ============================================
        async function buscarProductoPorCodigo(codigo) {
    try {
        const response = await fetch('index.php?c=producto&a=buscarPorCodigo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `codigo_barras=${encodeURIComponent(codigo)}`
        });

        const data = await response.json();

        if (data.success) {
            agregarAlCarrito(data.producto);
        } else {
            alert(data.message || 'Producto no encontrado');
            document.getElementById('barcode').focus();
        }

    } catch (error) {
        console.error('Error en JS:', error);
        alert('Error al buscar el producto');
        document.getElementById('barcode').focus();
    }
}

        // ============================================
        // FUNCIONES DEL CARRITO
        // ============================================
        function agregarAlCarrito(producto) {
            // Verificar stock
            if (producto.stock <= 0) {
                alert('Producto sin stock disponible');
                return;
            }

            // Verificar si el producto ya está en el carrito
            const existe = carrito.find(item => item.id === producto.id);
            
            if (existe) {
                // Verificar que no exceda el stock
                if (existe.cantidad + 1 > producto.stock) {
                    alert(`Stock insuficiente. Disponible: ${producto.stock}`);
                    return;
                }
                
                // Si ya existe, aumentar cantidad
                existe.cantidad++;
                existe.subtotal = existe.cantidad * existe.precio;
            } else {
                // Si no existe, agregarlo
                carrito.push({
                    id: producto.id,
                    nombre: producto.nombre,
                    precio: parseFloat(producto.precio),
                    stock: parseInt(producto.stock),
                    cantidad: 1,
                    subtotal: parseFloat(producto.precio)
                });
            }
            
            actualizarVista();
            
            // Devolver foco al input de código de barras
            document.getElementById('barcode').focus();
        }

        function eliminarDelCarrito(productoId) {
            carrito = carrito.filter(item => item.id !== productoId);
            actualizarVista();
        }

        function cancelarVenta() {
            carrito = [];
            actualizarVista();
            document.getElementById('barcode').focus();
        }

        // ============================================
        // ACTUALIZAR VISTA
        // ============================================
        function actualizarVista() {
            const saleList = document.querySelector('.sale-list');
            saleList.innerHTML = '';
            
            if (carrito.length === 0) {
                saleList.innerHTML = '<div class="empty-cart">No hay productos en la venta</div>';
                document.querySelector('.sale-total span').textContent = '$0.00';
                return;
            }
            
            let total = 0;
            
            carrito.forEach(item => {
                total += item.subtotal;
                
                const itemDiv = document.createElement('div');
                itemDiv.className = 'sale-item';
                itemDiv.innerHTML = `
                    <span class="name">${item.nombre}</span>
                    <span class="qty">x${item.cantidad}</span>
                    <span class="price">$${item.precio.toFixed(2)}</span>
                    <span class="subtotal">$${item.subtotal.toFixed(2)}</span>
                    <button class="remove-btn" onclick="eliminarDelCarrito('${item.id}')">✕</button>
                `;
                
                saleList.appendChild(itemDiv);
            });
            
            document.querySelector('.sale-total span').textContent = `$${total.toFixed(2)}`;
        }

        // ============================================
    // PROCESAR VENTA
    // ============================================
    async function procesarVenta() {
        const metodoPago = document.getElementById('payment').value;
        const total = carrito.reduce((sum, item) => sum + item.subtotal, 0);
    
        // Confirmar venta
        if (!confirm(`¿Procesar venta de $${total.toFixed(2)} con ${metodoPago}?`)) {
            return;
        }
    
        try {
            const response = await fetch('index.php?c=venta&a=registrarVenta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    metodo_pago: metodoPago,
                    productos: carrito.map(item => ({
                        producto_id: item.id,
                        nombre: item.nombre,
                        cantidad: item.cantidad,
                        precio_unitario: item.precio
                    }))
                })
            });
        
        const data = await response.json();
        
        if (data.success) {
            alert(`Venta registrada exitosamente\nTotal: $${total.toFixed(2)}`);
            cancelarVenta(); // Limpiar carrito
        } else {
            alert(data.message || 'Error al procesar la venta');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la venta');
    }
}