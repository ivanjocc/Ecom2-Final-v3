<?php

require_once 'model/UserOrder.php'; // Asegúrate de incluir el camino correcto
require_once 'model/OrderHasProduct.php';
require_once 'model/Product.php';

class OrderController {
    private $orderModel;
    private $orderHasProductModel;
    private $productModel;

    public function __construct($db) {
        $this->orderModel = new UserOrder($db);
        $this->orderHasProductModel = new OrderHasProduct($db);
        $this->productModel = new Product($db);
    }

    // Método para confirmar un pedido
    public function confirmOrder($userId, $products) {
        // $products debe ser un array de productos con su cantidad y precio
        $this->orderModel->user_id = $userId;
        $this->orderModel->date = date('Y-m-d'); // Fecha actual
        // Calcula el total del pedido basado en los productos
        $total = 0;
        foreach ($products as $product) {
            $total += $product['price'] * $product['quantity'];
        }
        $this->orderModel->total = $total;
        
        if ($this->orderModel->create()) {
            $orderId = $this->orderModel->id; // Asegúrate de obtener el ID del pedido recién creado
            foreach ($products as $product) {
                $this->orderHasProductModel->order_id = $orderId;
                $this->orderHasProductModel->product_id = $product['id'];
                $this->orderHasProductModel->quantity = $product['quantity'];
                $this->orderHasProductModel->price = $product['price'];
                $this->orderHasProductModel->addToOrder();
                // Aquí también podrías actualizar el inventario del producto
            }
            echo "Pedido confirmado exitosamente.";
            // Redirige al usuario a una página de éxito
        } else {
            echo "Ocurrió un error al confirmar el pedido.";
            // Redirige al usuario a una página de error
        }
    }

    // Método para ver el carrito de compras (esto es solo un ejemplo)
    public function viewCart($userId) {
        // Aquí implementarías la lógica para mostrar el carrito basado en el usuario
        // Esto podría incluir recuperar productos del carrito temporal o de una base de datos
        include 'view/order/view_cart.php';
    }
}
?>
