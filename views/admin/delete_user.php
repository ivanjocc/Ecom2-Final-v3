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

// Check if the user ID to be deleted is provided
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Connect to the database (adjust the path based on your file structure)
    require_once('../../config/database.php');

    // Query to delete the user using prepared statement
    $delete_query = "DELETE FROM `user` WHERE `id` = ?";
    
    // Prepare the delete query
    $stmt = mysqli_prepare($conn, $delete_query);

    // Bind the user_id parameter
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the delete query
    $result = mysqli_stmt_execute($stmt);

    // Check if the deletion was successful
    if ($result) {
        header("Location: dashboard.php");
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "User ID not provided.";
}
?>
