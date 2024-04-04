<?php

class Role {
    // Propiedades que representan las columnas de la tabla.
    public $id;
    public $name;
    public $description;

    // Conexión a la base de datos
    private $conn;
    private $table_name = "role";

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un nuevo rol
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";

        $stmt = $this->conn->prepare($query);

        // Limpieza y vinculación de datos
        $stmt->bindParam(":name", htmlspecialchars(strip_tags($this->name)));
        $stmt->bindParam(":description", htmlspecialchars(strip_tags($this->description)));

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para leer todos los roles
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Método para leer un solo rol por su ID
    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        // Limpieza y vinculación de datos
        $stmt->bindParam(":id", htmlspecialchars(strip_tags($id)));

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
    }
}

?>
