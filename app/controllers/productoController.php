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

        public function editar() {
            $id = $_GET['id'] ?? '';
    
            if (empty($id)) {
                header('Location: index.php?c=producto&a=gestionar');
                exit();
            }
    
            // Obtener datos del producto
            $producto = $this->productoModel->obtenerPorId($id);
    
            if (!$producto) {
                header('Location: index.php?c=producto&a=gestionar');
                exit();
            }
    
            // Obtener categorías activas para el dropdown
            require_once __DIR__ . '/../models/categoriaModel.php';
            $categoriaModel = new CategoriaModel();
            $todasCategorias = $categoriaModel->obtenerTodas();
    
            // Filtrar solo las activas
            $categorias = array_filter($todasCategorias, function($cat) {
                return $cat['estatus'] == 1;
            });
    
            require_once '../app/views/admin/producto/editar.php';
        }

        public function actualizar() {
            header('Content-Type: application/json');
    
            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $stockMinimo = $_POST['stock_minimo'] ?? 0;
            $imagenUrl = $_POST['imagen_url'] ?? '';
            $categoriaId = $_POST['categoria_id'] ?? '';
    
            if (empty($id) || empty($nombre) || empty($categoriaId)) {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
                return;
            }
    
            try {
                $resultado = $this->productoModel->editar(
                    $id,
                    $nombre,
                    $descripcion,
                    $precio,
                    $stockMinimo,
                    $imagenUrl,
                    $categoriaId
                );
        
                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Producto actualizado exitosamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto']);
                }
        
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function ajustarStock() {
            $id = $_GET['id'] ?? '';
    
            if (empty($id)) {
                header('Location: index.php?c=producto&a=gestionar');
                exit();
            }
    
            // Obtener datos del producto
            $producto = $this->productoModel->obtenerPorId($id);
    
            if (!$producto) {
                header('Location: index.php?c=producto&a=gestionar');
                exit();
            }
    
            require_once '../app/views/admin/producto/ajustarStock.php';
        }

        public function modificarStock() {
            header('Content-Type: application/json');
    
            $id = $_POST['id'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 0;
            $accion = $_POST['accion'] ?? '';
    
            if (empty($id) || $cantidad <= 0 || !in_array($accion, ['aumentar', 'disminuir'])) {
                echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
                return;
            }
    
            try {
                if ($accion === 'aumentar') {
                    $resultado = $this->productoModel->aumentarStock($id, $cantidad);
                } else {
                    // Verificar que haya suficiente stock antes de disminuir
                    $stockActual = $this->productoModel->obtenerPorId($id);
                    if ($stockActual['stock'] < $cantidad) {
                        echo json_encode(['success' => false, 'message' => 'Stock insuficiente para disminuir esa cantidad']);
                        return;
                    }
                    $resultado = $this->productoModel->disminuirStock($id, $cantidad);
                }
        
                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Stock actualizado']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el stock']);
                }
        
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function obtenerStock() {
            header('Content-Type: application/json');
    
            $id = $_GET['id'] ?? '';
    
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
                return;
            }
    
            try {
                $stock = $this->productoModel->obtenerPorId($id);
        
                if ($stock) {
                    echo json_encode([
                        'success' => true,
                        'stock' => $stock['stock'],
                        'stock_minimo' => $stock['stock_minimo']
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
                }
        
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }
    }

?>