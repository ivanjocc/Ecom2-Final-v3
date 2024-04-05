<?php

class UserOrder {
    // Propiedades de la clase que representan las columnas de la tabla.
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
        $query = "INSERT INTO " . $this->table_name . " 
                  (ref, date, total, user_id) 
                  VALUES 
                  (:ref, :date, :total, :user_id)";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":ref", $this->ref);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":total", $this->total);
        $stmt->bindParam(":user_id", $this->user_id);

        if($stmt->execute()) {
            return $this->conn->lastInsertId(); // Retorna el ID del pedido creado
        }

        return false;
    }

    // Método para leer todos los pedidos de un usuario
    public function readByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt;
    }

    // Método para leer un solo pedido por ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar los valores a las propiedades del objeto
        $this->id = $row['id'];
        $this->ref = $row['ref'];
        $this->date = $row['date'];
        $this->total = $row['total'];
        $this->user_id = $row['user_id'];
    }

    // Método para actualizar un pedido existente
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                      ref = :ref, 
                      date = :date, 
                      total = :total, 
                      user_id = :user_id
                  WHERE 
                      id = :id";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":ref", $this->ref);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":total", $this->total);
        $stmt->bindParam(":user_id", $this->user_id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un pedido
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

    public function getAllOrders() {
        // Preparar la consulta SQL para obtener todas las órdenes
        $query = "SELECT * FROM " . $this->table_name;
    
        // Preparar la declaración
        $stmt = $this->conn->prepare($query);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Verificar si hay registros
        if ($stmt->rowCount() > 0) {
            // Crear un array para almacenar las órdenes
            $ordersArray = array();
    
            // Recorrer los resultados y añadirlos al array
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
    
                $orderItem = array(
                    "id" => $id,
                    "ref" => $ref,
                    "date" => $date,
                    "total" => $total,
                    "user_id" => $user_id
                );
    
                array_push($ordersArray, $orderItem);
            }
    
            return $ordersArray;
        } else {
            // No se encontraron órdenes
            return "No orders found.";
        }
    }
    
}
