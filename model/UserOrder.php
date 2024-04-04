<?php

class UserOrder {
    // Propiedades que representan las columnas de la tabla.
    public $id;
    public $ref;
    public $date;
    public $total;
    public $user_id;

    // Conexión a la base de datos
    private $conn;
    private $table_name = "user_order";

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un nuevo pedido
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (ref, date, total, user_id) VALUES (:ref, :date, :total, :user_id)";

        $stmt = $this->conn->prepare($query);

        // Limpieza y vinculación de datos
        $stmt->bindParam(":ref", htmlspecialchars(strip_tags($this->ref)));
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":total", htmlspecialchars(strip_tags($this->total)));
        $stmt->bindParam(":user_id", htmlspecialchars(strip_tags($this->user_id)));

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para leer todos los pedidos
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Método para leer un pedido específico por su ID
    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        // Limpieza y vinculación de datos
        $stmt->bindParam(":id", htmlspecialchars(strip_tags($id)));

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id = $row['id'];
        $this->ref = $row['ref'];
        $this->date = $row['date'];
        $this->total = $row['total'];
        $this->user_id = $row['user_id'];
    }
}

?>
