<?php

class Product {
    // Propiedades de la clase que representan las columnas de la tabla.
    public $id;
    public $name;
    public $quantity;
    public $price;
    public $img_url;
    public $description;

    // Conexión a la base de datos
    private $conn;
    private $table_name = "product";

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un nuevo producto
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, quantity, price, img_url, description) 
                  VALUES 
                  (:name, :quantity, :price, :img_url, :description)";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":img_url", $this->img_url);
        $stmt->bindParam(":description", $this->description);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para leer todos los productos
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Método para leer un solo producto por ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar los valores a las propiedades del objeto
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->quantity = $row['quantity'];
        $this->price = $row['price'];
        $this->img_url = $row['img_url'];
        $this->description = $row['description'];
    }

    // Método para actualizar un producto existente
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                      name = :name, 
                      quantity = :quantity, 
                      price = :price, 
                      img_url = :img_url, 
                      description = :description
                  WHERE 
                      id = :id";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":img_url", $this->img_url);
        $stmt->bindParam(":description", $this->description);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un producto
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
