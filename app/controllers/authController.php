<?php

    require_once '../app/models/authModel.php';

    class AuthController {

        public function loadLogin() {
            require_once '../app/views/auth/login.php';
        }

        public function authenticate() {
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

            $authModel = new AuthModel();
            $usuario = $authModel->login($correo);

            if(!$usuario) {
                $error = "Credenciales incorrectas.";
                require_once '../app/views/auth/login.php';
                return;
            }

            if (!password_verify($password, $usuario['contra'])) {
                $error = "contra incorrecta.";
                require_once '../app/views/auth/login.php';
                return;
            }

            unset($usuario['contra']);
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php?c=home&a=main");
            exit;
        }

        public function logout() {
            // Lógica para cerrar sesión
            echo "Cerrando sesión...";
        }
    }

?>