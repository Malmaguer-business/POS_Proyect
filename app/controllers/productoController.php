<?php

    require_once __DIR__ . '/../models/productoModel.php';

    class productoController {
        private $productoModel;

        public function __construct() {
            $this->productoModel = new productoModel;
        }

        public function buscarPorCodigo() {
            header('Content-Type: application/json');
            $codigo = $_POST['codigo_barras'] ?? '';
            $producto = $this->productoModel->buscarPorCodigo($codigo);
            if(!$producto) {
                echo json_encode(['success' => false, 'message' => 'Código de barras inválido']);
                return;
            }
            echo json_encode(['success' => true, 'producto' => $producto]);
        }

        public function crear() {
            require_once __DIR__ . '/../models/categoriaModel.php';
            $categoriaModel = new CategoriaModel();
            $categorias = $categoriaModel->obtenerActivas();

            require_once '../app/views/admin/producto/registrar.php';
        }

        public function registrar() {
            header('Content-Type: application/json');
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $stockMinimo = $_POST['stock_minimo'] ?? 0;
            $codigoBarras = $_POST['codigo_barras'] ?? '';
            $imagenUrl = $_POST['imagen_url'] ?? '';
            $categoriaId = $_POST['categoria_id'] ?? '';

            // Validación básica
            if (empty($nombre) || empty($categoriaId)) {
                echo json_encode(['success' => false, 'message' => 'El nombre y la categoría son obligatorios']);
                return;
            }

            try {
                $resultado = $this->productoModel->registrar($nombre, $descripcion, $precio, $stock, $stockMinimo, $codigoBarras, $imagenUrl, $categoriaId);

                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Producto creado exitosamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al crear el producto']);
                }

            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function gestionar() {
            // Obtener todos los productos
            $productos = $this->productoModel->obtenerTodos();
    
            // Cargar la vista
            require_once '../app/views/admin/producto/gestionar.php';
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
                $resultado = $this->productoModel->cambiarEstatus($id, $estatus);
        
                if ($resultado) {
                    $mensaje = $estatus == 1 ? 'Producto activado' : 'Producto desactivado';
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