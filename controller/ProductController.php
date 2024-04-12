<?php

class ProductController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addProduct($name, $quantity, $price, $description, $image) {
        $targetDir = "../../public/img/";
        $imageName = basename($image['name']);
        $targetFile = $targetDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $checkImage = getimagesize($image['tmp_name']);

        if ($checkImage !== false) {
            if ($imageFileType != "jpg") {
                return "Only JPG files are allowed.";
            }

            // Create a unique file name to prevent overwriting
            $temp = explode(".", $imageName);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $targetFile = $targetDir . $newfilename;

            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                $imgPath = "public/img/" . $newfilename;
                $insertQuery = "INSERT INTO product (name, quantity, price, img_url, description) VALUES (?, ?, ?, ?, ?)";
                
                // Preparing the statement with PDO
                $stmt = $this->db->prepare($insertQuery);
                // Binding the parameters
                $stmt->bindParam(1, $name);
                $stmt->bindParam(2, $quantity);
                $stmt->bindParam(3, $price);
                $stmt->bindParam(4, $imgPath);
                $stmt->bindParam(5, $description);

                if ($stmt->execute()) {
                    return true;
                } else {
                    return "Error adding the product: " . $stmt->errorInfo()[2];
                }
            } else {
                return "Error uploading the image.";
            }
        } else {
            return "File is not an image.";
        }
    }

	public function listProducts() {
        $stmt = $this->db->prepare("SELECT id, name, price, quantity, description FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProduct($productId) {
        $stmt = $this->db->prepare("DELETE FROM product WHERE id = ?");
        $stmt->bindParam(1, $productId, PDO::PARAM_INT);
        $stmt->execute();
    }

	public function listCatProducts() {
        $stmt = $this->db->prepare("SELECT id, name, price, img_url FROM product WHERE category = 'Cat'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT id, name, quantity, price, img_url, description FROM product WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}


?>