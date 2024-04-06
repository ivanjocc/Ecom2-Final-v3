<?php

class LoginController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($username, $password) {
        $query = "SELECT id, user_name, pwd, role_id FROM user WHERE user_name = :username";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['pwd'])) {
                    // Las credenciales son correctas
                    return [
                        'success' => true,
                        'user_id' => $user['id'],
                        'username' => $user['user_name'],
                        'role_id' => $user['role_id']
                    ];
                } else {
                    // Contraseña incorrecta
                    return [
                        'success' => false,
                        'message' => 'La contraseña es incorrecta.'
                    ];
                }
            } else {
                // Nombre de usuario no encontrado
                return [
                    'success' => false,
                    'message' => 'El usuario no existe.'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Error al acceder a la base de datos.'
            ];
        }
    }
}

?>
