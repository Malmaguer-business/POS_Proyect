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

    }

?>