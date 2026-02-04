<?php

    require_once __DIR__ . '/../models/usuarioModel.php';

    class usuarioController {
        private $usuarioModel;

        public function __construct() {
            $this->usuarioModel = new usuarioModel;
        }

        public function crear() {
            require_once '../app/views/admin/usuario/registrar.php';
        }
    
        public function registrar() {
            header('Content-Type: application/json');
        
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $password = $_POST['password'] ?? '';
            $rol = $_POST['rol'] ?? 0;
        
            if (empty($nombre) || empty($correo) || empty($telefono) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
                return;
            }
        
            if ($this->usuarioModel->existeCorreo($correo)) {
                echo json_encode(['success' => false, 'message' => 'El correo ya está registrado']);
                return;
            }
        
            try {
                $resultado = $this->usuarioModel->registrar($nombre, $correo, $telefono, $password, $rol);
            
                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear el usuario']);
                }
            
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }
    }

?>