<?php
session_start();

require_once __DIR__ . '/../../controller/CartController.php';

$cartController = new CartController();

if (!isset($_SESSION['user_id'])) {
	header("Location: ../auth/login.php");
	exit();
}

// Manejo de acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['add_to_cart'])) {
		$cartController->addToCart($_POST['product_id'], $_POST['product_name'], $_POST['product_price']);
	} elseif (isset($_POST['empty_cart'])) {
		$cartController->emptyCart();
	} elseif (isset($_POST['confirm_order'])) {
		header("Location: confirm_order.php");
		exit();
	}
}

$items = $cartController->getCartItems();
$totalPrice = $cartController->getCartTotal();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cart</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding: 0;
			box-sizing: border-box;
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
			border-radius: 5px;
		}

		.cart-container {
			margin-top: 20px;
		}

		.cart-item {
			background-color: #f9f9f9;
			border: 1px solid #ddd;
			padding: 10px;
			margin-bottom: 10px;
			border-radius: 5px;
		}

		.cart-item p {
			margin: 5px 0;
			line-height: 1.6;
		}

		button {
			background-color: #28a745;
			color: #fff;
			padding: 8px 16px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		button:hover {
			background-color: #218838;
		}

		a {
			display: block;
			text-align: center;
			margin-top: 10px;
			color: #007BFF;
			text-decoration: none;
			transition: color 0.3s ease;
		}

		a:hover {
			color: #0056b3;
			text-decoration: underline;
		}

		form {
			margin-top: 15px;
		}
	</style>

</head>

<body>
	<main>
		<h1>Your Shopping Cart</h1>
		<div class="cart-container">
			<?php foreach ($items as $item) : ?>
				<div class="cart-item">
					<p><?= htmlspecialchars($item['name']) ?></p>
					<p>Price: $<?= htmlspecialchars($item['price']) ?></p>
					<p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
				</div>
			<?php endforeach; ?>

			<p>Total Price: $<?= number_format($totalPrice, 2) ?></p>

			<form action="confirm_order.php" method="post">
				
			</form>

			<form action="" method="post">
				<button type="submit" name="empty_cart">Empty Cart</button>
			</form>
			<a href="../../index.php">Home</a>
		</div>
	</main>
</body>

</html>