<?php
include('../../config/database.php'); // Include the database configuration file
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle unauthorized access
    header("Location: ../auth/login.php");
    exit();
}

$conn = $GLOBALS['conn']; // Get the database connection

// Get user information
$user_id = $_SESSION['user_id'];

// Get shipping address information from the database
$sql = "SELECT u.*, a.* FROM `user` u
        JOIN `address` a ON u.shipping_address_id = a.id
        WHERE u.id = ?";
$stmt = mysqli_prepare($conn, $sql); // Prepare a SQL statement
mysqli_stmt_bind_param($stmt, "i", $user_id); // Bind parameters
mysqli_stmt_execute($stmt); // Execute the prepared statement
$result = mysqli_stmt_get_result($stmt); // Get the result

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Get shipping address information
    $street_name = $row['street_name'];
    $street_nb = $row['street_nb'];
    $city = $row['city'];
    $province = $row['province'];
    $zip_code = $row['zip_code'];
    $country = $row['country'];
} else {
    // Handle the case where shipping address information cannot be retrieved
    header("Location: failure.php?error=address");
    exit();
}

// Get products from the cart
$cart_products = $_SESSION['cart'];

// Calculate the total price based on the products in the cart
$total_price = 0;
foreach ($cart_products as $product) {
    $total_price += $product['quantity'] * $product['price'];
}

// Insert into the user_order table
$order_reference = generateOrderReference(); // Define a function to generate a unique order reference
$sql_insert_order = "INSERT INTO `user_order` (`ref`, `date`, `total`, `user_id`) VALUES (?, NOW(), ?, ?)";
$stmt_insert_order = mysqli_prepare($conn, $sql_insert_order);
mysqli_stmt_bind_param($stmt_insert_order, "sdi", $order_reference, $total_price, $user_id);
$result_insert_order = mysqli_stmt_execute($stmt_insert_order);

if (!$result_insert_order) {
    // Handle the error when inserting into the user_order table
    header("Location: failure.php?error=order");
    exit();
}

// Get the order ID for further use
$order_id = mysqli_insert_id($conn);

// Clear session variables
unset($_SESSION['cart']);

// Redirect to the success page
header("Location: success.php");
exit();

// Function to generate a unique order reference
function generateOrderReference() {
    // Implement your logic to generate a unique reference, for example, using timestamp and a prefix
    return 'ORD' . time();
}
?>
