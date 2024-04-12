<?php

class UserController {
    public $users = [];
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function updateUser($user_id, $fname, $lname) {
        $query = "UPDATE `user` SET fname = :fname, lname = :lname WHERE id = :user_id";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Manejo del error
            return false;
        }
    }

    public function listUsers() {
        try {
            $query = "SELECT id, user_name, email, fname, lname FROM user";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
