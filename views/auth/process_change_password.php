<?php
// Include the database configuration file
require_once('../../config/database.php');

// Start a session
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not authenticated
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input values
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Validate empty fields
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $error_message = "All fields are required.";
        header("Location: change_password.php?error=$error_message");
        exit();
    }

    // Retrieve the current password hash from the database using prepared statement
    $select_sql = "SELECT `pwd` FROM `user` WHERE `id` = ?";
    $select_stmt = mysqli_prepare($conn, $select_sql);
    mysqli_stmt_bind_param($select_stmt, "i", $user_id);
    mysqli_stmt_execute($select_stmt);
    $result = mysqli_stmt_get_result($select_stmt);
    $user = mysqli_fetch_assoc($result);

    // Verify the current password
    if (password_verify($current_password, $user['pwd'])) {
        // Check if the new passwords match
        if ($new_password === $confirm_new_password) {
            // Update the password using prepared statement
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE `user` SET `pwd` = ? WHERE `id` = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $user_id);
            mysqli_stmt_execute($update_stmt);

            // Redirect to the profile page after successful password update
            header("Location: profile.php");
            exit();
        } else {
            $error_message = "New passwords do not match.";
            header("Location: change_password.php?error=$error_message");
            exit();
        }
    } else {
        $error_message = "Current password is incorrect.";
        header("Location: change_password.php?error=$error_message");
        exit();
    }

    // Close the prepared statements
    mysqli_stmt_close($select_stmt);
    mysqli_stmt_close($update_stmt);
}

// Close the database connection
mysqli_close($conn);
?>
