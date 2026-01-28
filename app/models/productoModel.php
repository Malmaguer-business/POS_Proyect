<?php

    require_once 'database.php';

    class productoModel extends Database {
        public function buscarPorCodigo($codigo) {
            $stmt = $this->conn->prepare("CALL sp_buscar_producto_por_codigo(?)");
            $stmt->bind_param("s", $codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

        public function registrar($nombre, $descripcion, $precio, $stock, $stockMinimo, $codigoBarras, $imagenUrl, $categoriaId) {
            $stmt = $this->conn->prepare("CALL sp_registrar_producto(?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdiisss", $nombre, $descripcion, $precio, $stock, $stockMinimo, $codigoBarras, $imagenUrl, $categoriaId);
            return $stmt->execute();
        }

        public function obtenerTodos() {
            $stmt = $this->conn->prepare("CALL sp_todos_productos()");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerActivos() {
            $stmt = $this->conn->prepare("CALL sp_productos_activos()");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function cambiarEstatus($id, $estatus) {
            $stmt = $this->conn->prepare("CALL sp_toggle_productos(?, ?)");
            $stmt->bind_param("si", $id, $estatus);
            return $stmt->execute();
        
            }
    }
?>