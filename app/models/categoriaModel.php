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

        public function seleccionarCatgeoria($id) {
            $stmt = $this->conn->prepare("CALL sp_seleccionar_categoria(?)");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

        public function editar($id, $nombre, $descripcion) {
            $stmt = $this->conn->prepare("CALL sp_editar_categoria(?, ?, ?)");
            $stmt->bind_param("sss", $id, $nombre, $descripcion);
            return $stmt->execute();
        }

        public function obtenerActivas() {
            $stmt = $this->conn->prepare("CALL sp_categorias_activas()");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

?>