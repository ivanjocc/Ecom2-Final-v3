<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: ../auth/login.php");
    exit();
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handling addition to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        // Get product details and add to the cart
        $productId = $_POST['product_id'];
        $productName = $_POST['product_name'];
        $productPrice = $_POST['product_price'];

        // Check if the product is already in the cart
        $productInCart = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] === $productId) {
                $cartItem['quantity'] += 1; // Increment the quantity
                $productInCart = true;
                break;
            }
        }
        unset($cartItem); // Release the explicit reference

        // If the product is not in the cart, add it
        if (!$productInCart) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1,
            ];
        }
    } elseif (isset($_POST['empty_cart'])) {
        // Empty the cart when the button is clicked
        $_SESSION['cart'] = [];
    } elseif (isset($_POST['confirm_order'])) {
        // Redirect to the order confirmation page
        header("Location: confirm_order.php");
        exit();
    }
}

// Calculate total price of products in the cart
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .cart-container {
            margin-top: 20px;
        }

        .cart-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .cart-item p {
            margin: 5px 0;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <main>
        <h1>Your Shopping Cart</h1>

        <div class="cart-container">
            <?php
            // Display items in the cart
            foreach ($_SESSION['cart'] as $item) {
                echo '<div class="cart-item">';
                echo '<p>' . $item['name'] . '</p>';
                echo '<p>Price: $' . $item['price'] . '</p>';
                echo '<p>Quantity: ' . $item['quantity'] . '</p>';
                echo '</div>';
            }
            ?>

            <!-- Display total price of products -->
            <p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>

            <!-- Form to confirm the order -->
            <form action="confirm_order.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <?php foreach ($_SESSION['cart'] as $item) : ?>
                    <input type="hidden" name="product_id[]" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="product_name[]" value="<?php echo $item['name']; ?>">
                    <input type="hidden" name="product_price[]" value="<?php echo $item['price']; ?>">
                <?php endforeach; ?>
                <button type="submit" name="confirm_order">Confirm Order</button>
            </form>
            <br>

            <!-- Form to empty the cart -->
            <form action="" method="post">
                <button type="submit" name="empty_cart">Empty Cart</button>
            </form>
            <a href="../../index.php">Home</a>
        </div>
    </main>

</body>

</html>
