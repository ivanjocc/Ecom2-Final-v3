<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not authenticated
    header("Location: ../auth/login.php");
    exit();
}

// Get the user's role from the session
$user_role = $_SESSION['user_role'];

// Check if the user has the administrator role
if ($user_role != 1) {
    // Redirect to the homepage if the user is not an administrator
    header("Location: ../../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Include a CSS file (cursor.css) -->
    <link rel="stylesheet" href="../../public/css/cursor.css">

    <style>
        /* Style for the page */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style for the unordered list */
        ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        /* Style for list items */
        li {
            margin: 10px 0;
        }

        /* Style for links */
        a {
            display: block;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>

</head>

<body>
    <h2>Welcome to the Admin Dashboard</h2>

    <!-- Navigation menu using an unordered list -->
    <ul>
        <li><a href="../../index.php">Home</a></li>
        <li><a href="add_product.php">Add Product</a></li>
        <li><a href="manage_users.php">User List</a></li>
        <li><a href="view_search_orders.php">Order List</a></li>
        <li><a href="../auth/logout.php">Log out</a></li>
    </ul>

</body>

</html>
