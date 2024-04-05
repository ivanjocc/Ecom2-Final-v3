<?php

require_once 'model/User.php'; // Asegúrate de incluir el camino correcto

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login($user_name, $password) {
        $user = $this->userModel->getUserByUsername($user_name);

        if ($user && password_verify($password, $user['pwd'])) {
            // Iniciar sesión y almacenar el ID del usuario y su rol en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role_id'];

            // Redirección basada en el rol del usuario
            if ($user['role_id'] == 1) { // Admin
                header("Location: admin/dashboard.php");
                exit();
            } else { // Otros roles, por ejemplo, un cliente
                header("Location: profile.php");
                exit();
            }
        } else {
            // Redireccionar con un mensaje de error
            header("Location: login.php?error=Invalid username or password");
            exit();
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
