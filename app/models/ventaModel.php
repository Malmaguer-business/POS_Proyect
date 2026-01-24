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

    }

?>