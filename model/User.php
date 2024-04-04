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

    // Método para crear un nuevo usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (user_name, email, pwd, fname, lname, billing_address_id, shipping_address_id, token, role_id) VALUES (:user_name, :email, :pwd, :fname, :lname, :billing_address_id, :shipping_address_id, :token, :role_id)";

        $stmt = $this->conn->prepare($query);

        // Limpieza y vinculación de datos
        $stmt->bindParam(":user_name", htmlspecialchars(strip_tags($this->user_name)));
        $stmt->bindParam(":email", htmlspecialchars(strip_tags($this->email)));
        $stmt->bindParam(":pwd", password_hash($this->pwd, PASSWORD_DEFAULT)); // Hashing de la contraseña
        $stmt->bindParam(":fname", htmlspecialchars(strip_tags($this->fname)));
        $stmt->bindParam(":lname", htmlspecialchars(strip_tags($this->lname)));
        $stmt->bindParam(":billing_address_id", htmlspecialchars(strip_tags($this->billing_address_id)));
        $stmt->bindParam(":shipping_address_id", htmlspecialchars(strip_tags($this->shipping_address_id)));
        $stmt->bindParam(":token", htmlspecialchars(strip_tags($this->token))); // Considera cómo y cuándo generar este token
        $stmt->bindParam(":role_id", htmlspecialchars(strip_tags($this->role_id)));

        if($stmt->execute()) {
            return true;
        }

        return false;
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
