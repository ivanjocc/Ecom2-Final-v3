<?php

class Role {
    // Propiedades de la clase que representan las columnas de la tabla.
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
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, description) 
                  VALUES 
                  (:name, :description)";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para leer todos los roles
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Método para leer un solo rol por ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar los valores a las propiedades del objeto
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
    }

    // Método para actualizar un rol existente
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                      name = :name, 
                      description = :description
                  WHERE 
                      id = :id";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un rol
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
