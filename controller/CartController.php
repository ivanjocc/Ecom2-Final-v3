<?php

class CartController {
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addToCart($productId, $productName, $productPrice, $quantity = 1) {
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $productId) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $quantity
            ];
        }
    }

    public function removeFromCart($productId) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] === $productId) {
                unset($_SESSION['cart'][$index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    }

    public function emptyCart() {
        $_SESSION['cart'] = [];
    }

    public function getCartItems() {
        return $_SESSION['cart'];
    }

    public function getCartTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}

?>
