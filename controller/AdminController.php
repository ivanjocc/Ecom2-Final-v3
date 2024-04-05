<?php

require_once 'model/Product.php';
require_once 'model/User.php';
require_once 'model/UserOrder.php';

class AdminController {
    private $productModel;
    private $userModel;
    private $orderModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
        $this->userModel = new User($db);
        $this->orderModel = new UserOrder($db);
    }

    public function dashboardPage() {
        // Cargar datos necesarios para el dashboard si es necesario
        include 'views/admin/dashboard.php';
    }

    public function delete_user($userId) {
        // Lógica para eliminar un usuario
        $this->userModel->delete($userId);
        // Redirigir a la página de gestión de usuarios o mostrar un mensaje de éxito/error
    }

    public function manageUsersPage() {
        $users = $this->userModel->getAllUsers();
        include 'views/admin/manage_users.php';
    }

    public function showAllOrders() {
        // Llamar al método getAllOrders del modelo UserOrder
        $orders = $this->orderModel->getAllOrders();
    
        // Verificar si se han encontrado órdenes
        if (is_array($orders)) {
            // Pasar las órdenes a la vista correspondiente para su visualización
            include 'views/admin/view_all_orders.php'; // Asegúrate de que el path sea correcto
        } else {
            // Manejar el caso en que no se encuentren órdenes
            // Esto podría implicar mostrar un mensaje de error o redirigir a otra página
            echo "No orders found."; // O podrías incluir una vista que maneje este caso
        }
    }
    
}
