<?php

class RegisterController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($userDetails) {
        $email = $userDetails['email'];
        $username = $userDetails['user_name'];
        $password = $userDetails['pwd'];
        $role_id = $userDetails['role_id'];

        // Verificar si el correo electrónico o el nombre de usuario ya están registrados
        $checkQuery = "SELECT * FROM user WHERE email = :email OR user_name = :username";

        $stmt = $this->db->prepare($checkQuery);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "This email or username is already registered.";
        }

        // Cifrar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario
        $insertQuery = "INSERT INTO user (user_name, email, pwd, role_id) VALUES (:username, :email, :pwd, :role_id)";

        $stmt = $this->db->prepare($insertQuery);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', $hashedPassword);
        $stmt->bindParam(':role_id', $role_id);

        if ($stmt->execute()) {
            return "Registration successful!";
        } else {
            return "An error occurred during registration.";
        }
    }
}
?>
