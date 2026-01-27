<?php

    require_once __DIR__ . '/../models/categoriaModel.php';

    class categoriaController {
        private $categoriaModel;

        public function __construct() {
            $this->categoriaModel = new categoriaModel;
        }

        public function crear() {
            require_once '../app/views/admin/categoria/registrar.php';
        }

        public function registrar() {
            header('Content-Type: application/json');
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
    
            // Validación básica
            if (empty($nombre)) {
                echo json_encode(['success' => false, 'message' => 'El nombre es obligatorio']);
                return;
            }
    
            try {
                $resultado = $this->categoriaModel->registrar($nombre, $descripcion);
        
                if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Categoría creada exitosamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear la categoría']);
                }
        
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function gestionar() {
            $categorias = $this->categoriaModel->obtenerTodas();
            require_once '../app/views/admin/categoria/gestionar.php';
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
                $resultado = $this->categoriaModel->cambiarEstatus($id, $estatus);
        
                if ($resultado) {
                    $mensaje = $estatus == 1 ? 'Categoría activada' : 'Categoría desactivada';
                    echo json_encode(['success' => true, 'message' => $mensaje]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
                }
        
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function editar() {
            $id = $_GET['id'] ?? '';
            if (empty($id)) {
                header('Location: index.php?c=categoria&a=listar');
                exit();
            }

            $categoria = $this->categoriaModel->seleccionarCatgeoria($id);
            if (!$categoria) {
                header('Location: index.php?c=categoria&a=listar');
                exit();
            }

            require_once '../app/views/admin/categoria/editar.php';
        }

        public function actualizar() {
            header('Content-Type: application/json');

            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';

            if (empty($id) || empty($nombre) || empty($descripcion)) {
                echo json_encode(['success' => false, 'message' => 'Error. Datos incompletos.']);
                return;
            }

            try {
                $resultado = $this->categoriaModel->editar($id, $nombre, $descripcion);

                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Categoría actualizada exitosamente.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar la categoría.']);
                }

            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }
    }

?>