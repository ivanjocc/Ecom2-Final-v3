<?php

class Address {
    // Propiedades que representan las columnas de la tabla.
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
        $query = "INSERT INTO " . $this->table_name . " (street_name, street_nb, city, province, zip_code, country) VALUES (:street_name, :street_nb, :city, :province, :zip_code, :country)";
        
        $stmt = $this->conn->prepare($query);

        // Limpieza de datos
        $this->street_name=htmlspecialchars(strip_tags($this->street_name));
        $this->street_nb=htmlspecialchars(strip_tags($this->street_nb));
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->province=htmlspecialchars(strip_tags($this->province));
        $this->zip_code=htmlspecialchars(strip_tags($this->zip_code));
        $this->country=htmlspecialchars(strip_tags($this->country));

        // Vinculación de parámetros
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

}

?>
