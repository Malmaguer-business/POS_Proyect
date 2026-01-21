<?php

    class Database {

        protected $conn;
        public function __construct()
        {
            $this->conn = new mysqli('localhost:3308', 'root', '', 'pos_proyect');
            if ($this->conn->connect_error) {
                die("Conexión fallida: " . $this->conn->connect_error);
            }
        }
    }

    

?>