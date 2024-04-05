<?php

class User {
    // Propiedades que representan las columnas de la tabla.
    public $id;
    public $user_name;
    public $email;
    public $pwd; // Considera utilizar hash para almacenar contraseñas
    public $fname;
    public $lname;
    public $billing_address_id;
    public $shipping_address_id;
    public $token; // Utilizado para operaciones que requieren seguridad adicional
    public $role_id;

    // Conexión a la base de datos
    private $conn;
    private $table_name = "user";

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserByUsername($user_name) {
        $query = "SELECT * FROM `user` WHERE `user_name` = :user_name";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_name", $user_name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }


    // Método para leer todos los usuarios
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}

?>
