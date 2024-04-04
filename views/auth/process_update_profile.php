<?php
require_once('../../config/database.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Get form data
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    // Validate that all fields are filled
    if (empty($user_name) || empty($email) || empty($fname) || empty($lname)) {
        $error_message = "All fields must be filled.";
        header("Location: profile.php?error=$error_message");
        exit();
    }

    // Update user information in the database using prepared statement
    $sql = "UPDATE `user` 
            SET `user_name` = ?, `email` = ?, `fname` = ?, `lname` = ? 
            WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssi', $user_name, $email, $fname, $lname, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: profile.php");
    } else {
        $error_message = "Error updating profile: " . mysqli_error($conn);
        header("Location: profile.php?error=$error_message");
        exit();
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    echo "Access not allowed";
}

mysqli_close($conn);
?>
