<?php

require_once 'model/User.php'; // Asegúrate de incluir el camino correcto

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    // Método para mostrar el perfil de un usuario
    public function showProfile($userId) {
        $user = $this->userModel->getUserById($userId);
        if ($user) {
            include 'view/auth/profile.php'; // Asumiendo que tienes una vista para el perfil
        } else {
            echo "Usuario no encontrado.";
            // Manejo de la situación donde el usuario no se encuentra
        }
    }

    // Método para actualizar el perfil de un usuario
    public function updateProfile($userId, $user_name, $email, $fname, $lname) {
        $this->userModel->id = $userId;
        $this->userModel->user_name = $user_name;
        $this->userModel->email = $email;
        $this->userModel->fname = $fname;
        $this->userModel->lname = $lname;

        if ($this->userModel->update()) {
            echo "Perfil actualizado exitosamente.";
            // Redirige al usuario de vuelta a la página del perfil con un mensaje de éxito
        } else {
            echo "Ocurrió un error al actualizar el perfil.";
            // Manejo del error
        }
    }

    // Método para listar todos los usuarios (podría ser útil en un contexto administrativo)
    public function listUsers() {
        $users = $this->userModel->readAll();
        include 'view/admin/manage_users.php'; // Asumiendo que tienes una vista para esto
    }
}
?>
