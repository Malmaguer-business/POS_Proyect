<?php

    require_once 'database.php';

    class ventaModel extends Database  {
        public function beginTransaction() {
            return $this->conn->begin_transaction();
        }
        
        public function commit() {
            return $this->conn->commit();
        }
        
        public function rollback() {
            return $this->conn->rollback();
        }
        
        public function registrarVenta($usuarioId, $total, $metodoPago) {
            $stmt = $this->conn->prepare("CALL sp_registrar_venta(?, ?, ?, @venta_id)");
            $stmt->bind_param("sds", $usuarioId, $total, $metodoPago);
            $stmt->execute();
            
            $result = $this->conn->query("SELECT @venta_id AS venta_id");
            $row = $result->fetch_assoc();
            return $row['venta_id'];
        }

        public function registrarDetalleVenta ($ventaId, $productoId, $cantidad) {
            $stmt = $this->conn->prepare("CALL sp_registrar_detalles_venta(?, ?, ?)");
            $stmt->bind_param("ssi", $ventaId, $productoId, $cantidad);
            return $stmt->execute();
        }

        public function disminuirStock($productoId, $cantidad) {
            $stmt = $this->conn->prepare("CALL sp_disminuir_stock(?, ?)");
            $stmt->bind_param("si", $productoId, $cantidad);
            return $stmt->execute();
        }

        public function buscarPorFechas($fechaInicio, $fechaFin) {
            $stmt = $this->conn->prepare("CALL sp_ventas_por_fecha(?, ?)");
            $stmt->bind_param("ss", $fechaInicio, $fechaFin);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function buscarPorUsuario($usuarioId) {
            $stmt = $this->conn->prepare("CALL sp_ventas_por_usuario(?)");
            $stmt->bind_param("s", $usuarioId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function buscarPorProducto($productoId) {
            $stmt = $this->conn->prepare("CALL sp_ventas_por_producto(?)");
            $stmt->bind_param("s", $productoId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerDetalles($ventaId) {
            $stmt = $this->conn->prepare("CALL sp_detalles_venta(?)");
            $stmt->bind_param("s", $ventaId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function reporteResumen() {
            $stmt = $this->conn->prepare("CALL sp_reporte_resumen_general()");
            $stmt->execute();
    
            // Obtener resultados de los 4 SELECTs
            $result1 = $stmt->get_result();
            $ventasHoy = $result1->fetch_assoc();
    
            $stmt->next_result();
            $result2 = $stmt->get_result();
            $ventasMes = $result2->fetch_assoc();
    
            $stmt->next_result();
            $result3 = $stmt->get_result();
            $productoMasVendido = $result3->fetch_assoc();
    
            $stmt->next_result();
            $result4 = $stmt->get_result();
            $stockBajo = $result4->fetch_assoc();
    
            return [
                'ventas_hoy' => $ventasHoy['ventas_hoy'] ?? 0,
                'ingresos_hoy' => $ventasHoy['ingresos_hoy'] ?? 0,
                'ventas_mes' => $ventasMes['ventas_mes'] ?? 0,
                'ingresos_mes' => $ventasMes['ingresos_mes'] ?? 0,
                'producto_mas_vendido' => $productoMasVendido['producto_nombre'] ?? 'N/A',
                'cantidad_vendida' => $productoMasVendido['cantidad_vendida'] ?? 0,
                'productos_stock_bajo' => $stockBajo['productos_stock_bajo'] ?? 0
            ];
        }

        public function reporteTopProductos($limite = 5) {
            $stmt = $this->conn->prepare("CALL sp_reporte_top_productos(?)");
            $stmt->bind_param("i", $limite);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function reporteMetodosPago() {
            $stmt = $this->conn->prepare("CALL sp_reporte_metodos_pago()");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function reporteRendimientoEmpleados() {
            $stmt = $this->conn->prepare("CALL sp_reporte_rendimiento_empleados()");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function reporteProductosStockBajo() {
            $stmt = $this->conn->prepare("CALL sp_reporte_productos_stock_bajo()");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerVentaPorId($ventaId) {
            $stmt = $this->conn->prepare("CALL sp_obtener_venta_por_id(?)");
            $stmt->bind_param("s", $ventaId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

    }

?>