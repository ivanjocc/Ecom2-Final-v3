<?php
// Start a session
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not authenticated
    header("Location: ../auth/login.php");
    exit();
}

// Get the user role from the session
$user_role = $_SESSION['user_role'];

// Check if the user has the administrator role
if ($user_role != 1) {
    // Redirect to the home page if the user is not an administrator
    header("Location: ../../index.php");
    exit();
}

// Check if the user ID to update is provided
if (isset($_GET['user_id'])) {
    // Get the user ID from the URL
    $user_id = $_GET['user_id'];

    // Connect to the database (adjust the path based on your file structure)
    require_once('../../config/database.php');

    // Query to update the user's role to 'admin' using prepared statement
    $update_query = "UPDATE `user` SET `role_id` = 1 WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $update_query);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if ($result) {
        // Redirect to the dashboard after a successful update
        header("Location: dashboard.php");
    } else {
        // Display an error message if there's an issue with the database update
        echo "Error updating user role: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Close the database connection
    mysqli_close($conn);
} else {
    // Display a message if the user ID is not provided
    echo "User ID not provided.";
}
?>
