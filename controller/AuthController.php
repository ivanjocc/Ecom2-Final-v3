<?php

require_once 'model/User.php'; // Asegúrate de incluir el camino correcto

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    // Método para iniciar sesión
    public function login($username, $password) {
        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user->pwd)) {
            // Establece las sesiones u otras lógicas necesarias
            echo "Inicio de sesión exitoso.";
            // Redirige a la página de perfil o dashboard
        } else {
            echo "Credenciales incorrectas.";
            // Redirige de nuevo al formulario de login con mensaje de error
        }
    }

    // Método para registrar un nuevo usuario
    public function register($username, $email, $password, $fname, $lname) {
        // Aquí agregarías lógica para validar los datos del formulario

        $this->userModel->user_name = $username;
        $this->userModel->email = $email;
        $this->userModel->pwd = password_hash($password, PASSWORD_DEFAULT); // Hash de la contraseña
        $this->userModel->fname = $fname;
        $this->userModel->lname = $lname;

        if ($this->userModel->create()) {
            echo "Registro exitoso.";
            // Redirige al usuario a la página de inicio de sesión
        } else {
            echo "Ocurrió un error al registrar el usuario.";
            // Redirige de nuevo al formulario de registro con mensaje de error
        }
    }

    // Método para cambiar la contraseña
    public function changePassword($userId, $oldPassword, $newPassword) {
        $user = $this->userModel->getUserById($userId);

        if ($user && password_verify($oldPassword, $user->pwd)) {
            $this->userModel->id = $userId;
            $this->userModel->pwd = password_hash($newPassword, PASSWORD_DEFAULT);
            if ($this->userModel->updatePassword()) {
                echo "Cambio de contraseña exitoso.";
                // Redirige a la página de perfil o alguna otra página
            } else {
                echo "Error al cambiar la contraseña.";
                // Manejo del error
            }
        } else {
            echo "La contraseña actual no coincide.";
            // Redirige de nuevo al formulario de cambio de contraseña con mensaje de error
        }
    }
}
?>
