<?php

    require_once 'database.php';

    class productModel extends Database {
        public function buscarPorCodigo($codigo) {
            $stmt = $this->conn->prepare("CALL sp_buscar_producto_por_codigo(?)");
            $stmt->bind_param("s", $codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
    }

?>