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

        public function gestionar() {
            // Obtener todos los usuarios
            $usuarios = $this->usuarioModel->obtenerTodos();
    
            // Cargar la vista
            require_once '../app/views/admin/usuario/gestionar.php';
        }

        public function toggleEstatus() {
            header('Content-Type: application/json');
    
            $id = $_POST['id'] ?? '';
            $estatus = $_POST['estatus'] ?? '';
    
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
                return;
            }
    
            try {
                $resultado = $this->usuarioModel->cambiarEstatus($id, $estatus);
        
                if ($resultado) {
                    $mensaje = $estatus == 1 ? 'Usuario activado' : 'Usuario desactivado';
                    echo json_encode(['success' => true, 'message' => $mensaje]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
                }
        
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }
    }

?>