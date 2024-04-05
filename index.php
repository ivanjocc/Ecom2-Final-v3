<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handling addition to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
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

    // Display an alert that the item has been added
    echo '<script>alert("Item has been added to the cart!");</script>';
}
?>

<?php

require_once './config/connexionDB.php'; // Asegúrate de que la ruta sea correcta
require_once './controller/AuthController.php'; // Ajusta la ruta según sea necesario
require_once './controller/UserController.php'; // Ajusta la ruta según sea necesario

// Establece una conexión a la base de datos
$db = connexionDB::getConnection();

// Inicia el controlador de autenticación
$authController = new AuthController($db);

// Inicia el controlador de usuario
$userController = new UserController($db);

// Manejar la acción de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $userDetails = [
        'user_name' => $_POST['user_name'],
        'email' => $_POST['email'],
        'pwd' => $_POST['pwd'],
        // Define el role_id aquí, si es necesario
        'role_id' => 2, // Suponiendo que 2 es el role_id para 'client'
    ];
    
    $registrationResult = $authController->register($userDetails);

    // Continuación del manejo de la acción de registro
    if ($registrationResult === "Registration successful!") {
        // Si el registro fue exitoso, puedes optar por iniciar sesión automáticamente al usuario
        // y redirigirlo a una página específica, como el dashboard o la página principal
        // Por ejemplo, iniciar sesión:
        $_SESSION['user_email'] = $userDetails['email']; // Asegúrate de también almacenar cualquier otra información de sesión necesaria
        $_SESSION['user_role_id'] = $userDetails['role_id'];

        // Redirigir a la página después del registro exitoso
        header('Location: view/auth/login.php'); // Ajusta este destino según tu aplicación
        exit();
    } else {
        // Si hubo un error durante el registro, muestra un mensaje de error
        // o redirige al usuario de vuelta al formulario de registro con el mensaje de error.
        
        // Puedes almacenar el mensaje de error en la sesión para mostrarlo en la página de registro
        $_SESSION['registration_error'] = $registrationResult;

        // Redirigir de vuelta al formulario de registro
        header('Location: view/auth/register.php'); // Asegúrate de que esta ruta sea correcta
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
        $username = $_POST['user_name']; // Asegúrate de que este campo corresponde con tu formulario.
        $password = $_POST['pwd'];
    
        if ($authController->login($username, $password)) {
            // Login exitoso
            header('Location: view/auth/profile.php'); // Ajusta esta ruta.
            exit();
        } else {
            // Login fallido
            $_SESSION['login_error'] = 'Invalid username or password';
            header('Location: view/auth/login.php'); // Ajusta esta ruta.
            exit();
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIAO</title>
    <link rel="stylesheet" href="./public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8f9fa;
        }

        header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-around;
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #343a40;
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 10px;
        }

        main {
            max-width: 1200px;
            margin: 20px auto;
            padding-bottom: 30px;
        }

        .cat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .cat-item img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
            padding-top: 20px;
            border-radius: 20px;
        }

        .cat-item-details {
            padding: 10px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>
    <h1>Welcome to the Cat Shop</h1>

    <div class="cat-container">
        <?php
        // Get the list of cat images from the images directory
        $catImages = glob('public/img/*.jpg');

        foreach ($catImages as $catImage) {
            // Get the filename (without the path)
            $catName = pathinfo($catImage, PATHINFO_FILENAME);
            ?>

            <div class="cat-item">
                <img src="<?= $catImage ?>" alt="<?= $catName ?>">
                <p><?= $catName ?></p>

                <!-- Add a form with hidden fields to send product details -->
                <form method="post">
                    <input type="hidden" name="product_id" value="<?= $catName ?>">
                    <input type="hidden" name="product_name" value="<?= $catName ?>">
                    <input type="hidden" name="product_price" value="19.99">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
