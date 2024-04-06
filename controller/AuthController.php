<?php

require_once 'model/User.php';

class AuthController {
    private $userModel;
    private $errorMessage;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login($username, $password) {
        // Primero, obtén el usuario de la base de datos por su username
        $user = $this->userModel->getUserByUsername($username);
    
        if ($user && password_verify($password, $user['pwd'])) {
            // Asegúrate de que la sesión está iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role_id'];
    
            // Redirige al usuario según su rol
            $redirectUrl = ($user['role_id'] == 1) ? "view/admin/dashboard.php" : "profile.php";
            header("Location: $redirectUrl");
            exit();
        } else {
            // Si la autenticación falla, configura un mensaje de error
            $this->errorMessage = "Invalid username or password.";
            return false; // Indica que el inicio de sesión no fue exitoso
        }
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

    public function getErrorMessage() {
        return $this->errorMessage;
    }
}
