<?php

class Address {
    // Propiedades de la clase que representan las columnas de la tabla.
    public $id;
    public $street_name;
    public $street_nb;
    public $city;
    public $province;
    public $zip_code;
    public $country;

    // Conexión a la base de datos
    private $conn;
    private $table_name = "address";

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una nueva dirección
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (street_name, street_nb, city, province, zip_code, country) 
                  VALUES 
                  (:street_name, :street_nb, :city, :province, :zip_code, :country)";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":street_name", $this->street_name);
        $stmt->bindParam(":street_nb", $this->street_nb);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":zip_code", $this->zip_code);
        $stmt->bindParam(":country", $this->country);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para leer todas las direcciones
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Método para actualizar una dirección existente
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                      street_name = :street_name, 
                      street_nb = :street_nb, 
                      city = :city, 
                      province = :province, 
                      zip_code = :zip_code, 
                      country = :country
                  WHERE 
                      id = :id";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":street_name", $this->street_name);
        $stmt->bindParam(":street_nb", $this->street_nb);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":zip_code", $this->zip_code);
        $stmt->bindParam(":country", $this->country);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar una dirección
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
