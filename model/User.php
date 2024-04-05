<?php

class User {
    // Propiedades de la clase que representan las columnas de la tabla.
    public $id;
    public $user_name;
    public $email;
    public $pwd; // Considera almacenar solo hashes de contraseñas
    public $fname;
    public $lname;
    public $billing_address_id;
    public $shipping_address_id;
    public $token;
    public $role_id;

    // Conexión a la base de datos
    private $conn;
    private $table_name = "user";

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un nuevo usuario
    public function create($userDetails) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_name, email, pwd, role_id) 
                  VALUES 
                  (:user_name, :email, :pwd, :role_id)";
    
        $stmt = $this->conn->prepare($query);
    
        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":user_name", $userDetails['user_name']);
        $stmt->bindParam(":email", $userDetails['email']);
        $stmt->bindParam(":pwd", password_hash($userDetails['pwd'], PASSWORD_DEFAULT)); // Hash de la contraseña
        // Asegúrate de definir el role_id apropiadamente, por ejemplo, 2 para 'client'
        $role_id = 2; // Este valor debería ser dinámico basado en tu lógica de roles
        $stmt->bindParam(":role_id", $role_id);
    
        if($stmt->execute()) {
            return true;
        }
    
        return false;
    }
       

    // Método para leer todos los usuarios
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Método para leer un solo usuario por ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar los valores a las propiedades del objeto
        $this->id = $row['id'];
        $this->user_name = $row['user_name'];
        $this->email = $row['email'];
        $this->pwd = $row['pwd'];
        $this->fname = $row['fname'];
        $this->lname = $row['lname'];
        $this->billing_address_id = $row['billing_address_id'];
        $this->shipping_address_id = $row['shipping_address_id'];
        $this->token = $row['token'];
        $this->role_id = $row['role_id'];
    }

    // Método para actualizar un usuario existente
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                      user_name = :user_name, 
                      email = :email, 
                      pwd = :pwd, 
                      fname = :fname, 
                      lname = :lname, 
                      billing_address_id = :billing_address_id, 
                      shipping_address_id = :shipping_address_id, 
                      token = :token, 
                      role_id = :role_id
                  WHERE 
                      id = :id";

        $stmt = $this->conn->prepare($query);

        // Limpieza de datos y asignación de parámetros
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pwd", $this->pwd); // Asegúrate de hashear la contraseña si ha cambiado
        $stmt->bindParam(":fname", $this->fname);
        $stmt->bindParam(":lname", $this->lname);
        $stmt->bindParam(":billing_address_id", $this->billing_address_id);
        $stmt->bindParam(":shipping_address_id", $this->shipping_address_id);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":role_id", $this->role_id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un usuario
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

    public function getAllUsers() {
        // Preparar la consulta SQL
        $query = "SELECT id, user_name, email, fname, lname, role_id FROM " . $this->table_name;
    
        // Preparar la declaración
        $stmt = $this->conn->prepare($query);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Verificar si hay registros
        if($stmt->rowCount() > 0) {
            // Crear un array para almacenar los usuarios
            $usersArray = array();
    
            // Recorrer los resultados y añadirlos al array
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
    
                $userItem = array(
                    "id" => $id,
                    "user_name" => $user_name,
                    "email" => $email,
                    "fname" => $fname,
                    "lname" => $lname,
                    "role_id" => $role_id
                );
    
                array_push($usersArray, $userItem);
            }
    
            return $usersArray;
        } else {
            // No se encontraron usuarios
            return "No users found.";
        }
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public function findByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_name = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
