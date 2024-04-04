<?php
require_once('../../config/database.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $password = $_POST['pwd'];

    // Fetch user data from the database based on the provided username using prepared statement
    $sql = "SELECT * FROM `user` WHERE `user_name` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $user_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Check if the password matches
        if ($user && password_verify($password, $user['pwd'])) {
            // Password is correct, start the session and store user ID and role
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role_id'];

            // Redirect based on the user's role
            if ($user['role_id'] == 1) { // Admin
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: profile.php");
            }
            exit();
        } else {
            // Redirect with an error message
            header("Location: login.php?error=Invalid username or password");
            exit();
        }
    } else {
        // Redirect with an error message
        header("Location: login.php?error=Database error");
        exit();
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    // Redirect with an error message
    header("Location: login.php?error=Access not allowed");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
