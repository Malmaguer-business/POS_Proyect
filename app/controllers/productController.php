<?php

    require_once __DIR__ . '/../models/productModel.php';

    class productController {
        private $productModel;

        public function __construct() {
            $this->productModel = new productModel;
        }

        public function buscarPorCodigo() {
            header('Content-Type: application/json');
            $codigo = $_POST['codigo_barras'] ?? '';
            $producto = $this->productModel->buscarPorCodigo($codigo);
            if(!$producto) {
                echo json_encode(['success' => false, 'message' => 'Código de barras inválido']);
                return;
            }
            echo json_encode(['success' => true, 'producto' => $producto]);
        }
    }

?>