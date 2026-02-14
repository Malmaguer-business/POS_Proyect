<?php

    require_once __DIR__ . '/../models/ventaModel.php';
    require_once __DIR__ . '/../models/usuarioModel.php';
    require_once __DIR__ . '/../models/productoModel.php';

    class ventaController {
        private $ventaModel;
        private $usuarioModel;
        private $productoModel;

        public function __construct() {
            $this->ventaModel = new ventaModel;
            $this->usuarioModel = new usuarioModel;
            $this->productoModel = new productoModel;
        }

        public function registrarVenta() {
            header('Content-Type: application/json');

            $input = json_decode(file_get_contents('php://input'), true);
        
            if (!$input) {
                echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
                return;
            }
        
            $metodo_pago = $input['metodo_pago'] ?? '';
            $productos = $input['productos'] ?? [];
        
            // Validaciones
            if (empty($productos)) {
                echo json_encode(['success' => false, 'message' => 'No hay productos']);
                return;
            }   
        
            // Calcular total
            $total = 0;
            foreach ($productos as $producto) {
                $subtotal = $producto['cantidad'] * $producto['precio_unitario'];
                $total += $subtotal;
            }

            try {
                $this->ventaModel->beginTransaction();

                $usuarioId = $_SESSION['usuario']['id'];
                $ventaId = $this->ventaModel->registrarVenta($usuarioId, $total, $metodo_pago);

                foreach ($productos as $producto) {
                    $this->ventaModel->registrarDetalleVenta($ventaId, $producto['producto_id'], $producto['cantidad']);
                    $this->ventaModel->disminuirStock($producto['producto_id'], $producto['cantidad']);
                }

                $this->ventaModel->commit();
                echo json_encode(['success' => true, 'message' => 'Venta registrada exitosamente']);
            } 
            catch (Exception $e) {
                $this->ventaModel->rollback();
                echo json_encode(['success' => false, 'message' => 'Error al registrar la venta']);
                return;
            }
        } 

        public function historial() {
            $usuarios = $this->usuarioModel->obtenerTodos();
            $productos = $this->productoModel->obtenerActivos();
            require_once '../app/views/admin/venta/historial.php';
        }

        public function buscarPorFechas() {
            header('Content-Type: application/json');

            $fechaInicio = $_GET['fecha_inicio'] ?? '';
            $fechaFin = $_GET['fecha_fin'] ?? '';

            if (empty($fechaInicio) || empty($fechaFin)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Fechas no proporcionadas'
                ]);
                return;
            }

            try {
                $ventas = $this->ventaModel->buscarPorFechas($fechaInicio, $fechaFin);

                echo json_encode([
                    'success' => true,
                    'ventas' => $ventas
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al buscar ventas'
                ]);
            }
        }

        public function buscarPorUsuario() {
            header('Content-Type: application/json');
    
            $usuarioId = $_GET['usuario_id'] ?? '';
    
            if (empty($usuarioId)) {
                echo json_encode(['success' => false, 'message' => 'Usuario inválido']);
                return;
            }
    
            try {
                $ventas = $this->ventaModel->buscarPorUsuario($usuarioId);
                echo json_encode(['success' => true, 'ventas' => $ventas]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function buscarPorProducto() {
            header('Content-Type: application/json');
    
            $productoId = $_GET['producto_id'] ?? '';
    
            if (empty($productoId)) {
                echo json_encode(['success' => false, 'message' => 'Producto inválido']);
                return;
            }
    
            try {
                $ventas = $this->ventaModel->buscarPorProducto($productoId);
                echo json_encode(['success' => true, 'ventas' => $ventas]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function reportes() {
            require_once '../app/views/admin/venta/reportes.php';
        }

        public function reporteResumen() {
            header('Content-Type: application/json');
    
            try {
                $resumen = $this->ventaModel->reporteResumen();
                echo json_encode(['success' => true, 'resumen' => $resumen]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function reporteTopProductos() {
            header('Content-Type: application/json');
    
            try {
                $productos = $this->ventaModel->reporteTopProductos(5);
                echo json_encode(['success' => true, 'productos' => $productos]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function reporteMetodosPago() {
            header('Content-Type: application/json');
    
            try {
                $metodos = $this->ventaModel->reporteMetodosPago();
                echo json_encode(['success' => true, 'metodos' => $metodos]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function reporteRendimientoEmpleados() {
            header('Content-Type: application/json');
    
            try {
                $empleados = $this->ventaModel->reporteRendimientoEmpleados();
                echo json_encode(['success' => true, 'empleados' => $empleados]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function reporteProductosStockBajo() {
            header('Content-Type: application/json');
    
            try {
                $productos = $this->ventaModel->reporteProductosStockBajo();
                echo json_encode(['success' => true, 'productos' => $productos]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }

        public function detalles() {
            require_once '../app/views/admin/venta/detalles.php';
        }

        public function obtenerDetallesVenta() {
            header('Content-Type: application/json');
    
            $ventaId = $_GET['id'] ?? '';
    
            if (empty($ventaId)) {
                echo json_encode(['success' => false, 'message' => 'ID de venta inválido']);
                return;
            }
    
            try {
                // Obtener información de la venta
                $venta = $this->ventaModel->obtenerVentaPorId($ventaId);
                
                // Obtener detalles de productos
                $detalles = $this->ventaModel->obtenerDetalles($ventaId);
    
                if ($venta) {
                    echo json_encode([
                        'success' => true, 
                        'venta' => $venta,
                        'detalles' => $detalles
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Venta no encontrada']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
        }
    }
?>