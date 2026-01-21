<?php

    require_once 'database.php';

    class AuthModel extends Database {
        
        public function login($correo) {
            $stmt = $this->conn->prepare("CALL sp_login(?)");
            $stmt->bind_param("s", $correo);
            $stmt->execute();

            $result = $stmt->get_result();
            $usuario = $result ? $result->fetch_assoc() : null;
            $stmt->close();
            return $usuario;
        }
    }

?>