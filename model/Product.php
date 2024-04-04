<?php

class Product {
    // Propiedades que representan las columnas de la tabla.
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
        $query = "INSERT INTO " . $this->table_name . " (name, quantity, price, img_url, description) VALUES (:name, :quantity, :price, :img_url, :description)";

        $stmt = $this->conn->prepare($query);

        // Limpieza y vinculación de datos
        $stmt->bindParam(":name", htmlspecialchars(strip_tags($this->name)));
        $stmt->bindParam(":quantity", htmlspecialchars(strip_tags($this->quantity)));
        $stmt->bindParam(":price", htmlspecialchars(strip_tags($this->price)));
        $stmt->bindParam(":img_url", htmlspecialchars(strip_tags($this->img_url)));
        $stmt->bindParam(":description", htmlspecialchars(strip_tags($this->description)));

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para leer todos los productos
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

}

?>
