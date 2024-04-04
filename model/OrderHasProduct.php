<?php

class OrderHasProduct {
    // Propiedades que representan las columnas de la relación.
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
    public function addToOrder() {
        $query = "INSERT INTO " . $this->table_name . " (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos
        $this->order_id=htmlspecialchars(strip_tags($this->order_id));
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
        $this->price=htmlspecialchars(strip_tags($this->price));

        // Vinculación de parámetros
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>
