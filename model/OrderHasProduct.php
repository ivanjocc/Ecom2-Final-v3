<?php

class OrderHasProduct {
    // Propiedades de la clase que representan las columnas de la relación.
    public $order_id;
    public $product_id;
    public $quantity;
    public $price;

    // Conexión a la base de datos
    private $conn;
    private $table_name = "order_has_product";

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para añadir un producto a un pedido
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (order_id, product_id, quantity, price) 
                  VALUES 
                  (:order_id, :product_id, :quantity, :price)";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para leer los productos de un pedido específico
    public function readByOrderId($order_id) {
        $query = "SELECT p.name, p.description, op.quantity, op.price
                  FROM " . $this->table_name . " op
                  INNER JOIN product p ON op.product_id = p.id
                  WHERE op.order_id = :order_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();

        return $stmt;
    }

    // Método para actualizar la cantidad o el precio de un producto en un pedido
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET quantity = :quantity, price = :price
                  WHERE order_id = :order_id AND product_id = :product_id";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un producto de un pedido
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE order_id = :order_id AND product_id = :product_id";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":product_id", $this->product_id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
