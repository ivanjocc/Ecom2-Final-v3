<?php

require_once 'model/User.php'; // Asegúrate de que la ruta al archivo del modelo User sea correcta.

class AuthController {
    private $userModel;
    private $user;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login($username, $password) {
        $user = $this->userModel->findByUsername($username);
        if (!$user) {
            return false; // Usuario no encontrado
        }

        if (password_verify($password, $user['pwd'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['role_id'] = $user['role_id'];
            return true;
        }

        return false; // La contraseña no coincide
    }

    public function register($userDetails) {
        // Verificar si el correo electrónico ya está registrado
        if ($this->userModel->findByEmail($userDetails['email'])) {
            // Manejar el caso en que el correo electrónico ya esté en uso
            return "This email is already registered.";
        }

        // Cifrar la contraseña
        $userDetails['pwd'] = password_hash($userDetails['pwd'], PASSWORD_DEFAULT);

        // Insertar el nuevo usuario
        if ($this->userModel->create($userDetails)) {
            // Registro exitoso
            // Aquí podrías iniciar sesión automáticamente al usuario o redirigirlo a la página de inicio de sesión
            return "Registration successful!";
        } else {
            // Error al crear el usuario
            return "An error occurred during registration.";
        }
    }


    public function logout() {
        // Iniciar sesión
        session_start();
        // Destruir todas las variables de sesión
        $_SESSION = array();
        // Destruir la sesión
        session_destroy();
        // Redirigir a la página de login
        header("Location: login.php");
        exit();
    }

    public function getUserId() {
        return $this->user['id'] ?? null;
    }

    public function getUserRole() {
        return $this->user['role_id'] ?? null;
    }
}
