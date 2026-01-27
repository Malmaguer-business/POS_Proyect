<?php

    require_once 'database.php';

    class categoriaModel extends Database {
        public function registrar($nombre, $descripcion) {
            $stmt = $this->conn->prepare("CALL sp_registrar_categoria(?, ?)");
            $stmt->bind_param("ss", $nombre, $descripcion);
            return $stmt->execute();
        }

        public function obtenerTodas() {
            $stmt = $this->conn->prepare("CALL sp_todas_categorias()");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function cambiarEstatus($id, $estatus) {
           $stmt = $this->conn->prepare("CALL sp_toggle_categoria(?, ?)");
            $stmt->bind_param("si", $id, $estatus);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
    }

?>