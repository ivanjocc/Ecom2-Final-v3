<?php

require_once '../model/Product.php';
require_once '../model/User.php';
require_once '../model/UserOrder.php';

class AdminController {
    private $productModel;
    private $userModel;
    private $orderModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
        $this->userModel = new User($db);
        $this->orderModel = new UserOrder($db);
    }

    // Método para mostrar el dashboard administrativo
    public function showDashboard() {
        include 'view/admin/dashboard.php';
    }

    // Método para agregar un producto
    public function addProduct($name, $quantity, $price, $imgUrl, $description) {
        $this->productModel->name = $name;
        $this->productModel->quantity = $quantity;
        $this->productModel->price = $price;
        $this->productModel->img_url = $imgUrl;
        $this->productModel->description = $description;

        if ($this->productModel->create()) {
            echo "Producto agregado exitosamente.";
        } else {
            echo "Ocurrió un error al agregar el producto.";
        }
    }

    // Método para gestionar usuarios
    public function manageUsers() {
        $users = $this->userModel->readAll();
        include 'view/admin/manage_user.php';
    }
}
?>
