<?php

class OrderController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createOrder($userID, $totalPrice) {
        $ref = uniqid();
        $date = date('Y-m-d');
        
        $query = "INSERT INTO user_order (ref, date, total, user_id) VALUES (:ref, :date, :total, :user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ref', $ref);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':total', $totalPrice);
        $stmt->bindParam(':user_id', $userID);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function getAllOrders() {
        $sql = "SELECT o.id, o.ref, o.date, o.total, u.user_name FROM user_order o JOIN user u ON o.user_id = u.id ORDER BY o.date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
