<?php

    require_once 'database.php';

    class usuarioModel extends Database {
        public function registrar($nombre, $correo, $telefono, $password, $rol) {
            // Hash de la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
            $stmt = $this->conn->prepare("CALL sp_registrar_usuario(?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $nombre, $correo, $telefono, $passwordHash, $rol);
            return $stmt->execute();
        }
    
        public function obtenerTodos() {
            $stmt = $this->conn->prepare("CALL sp_todos_usuarios()");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    
        public function obtenerPorId($id) {
            $stmt = $this->conn->prepare("CALL sp_seleccionar_usuario(?)");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
    
        public function existeCorreo($correo) {
            $stmt = $this->conn->prepare("CALL sp_verificar_correo_existe(?)");
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['total'] > 0;
        }
    
        public function cambiarEstatus($id, $estatus) {
            $stmt = $this->conn->prepare("CALL sp_toggle_usuario(?, ?)");
            $stmt->bind_param("si", $id, $estatus);
            return $stmt->execute();
        }
    }

?>