<?php
session_start(); // Start the session

require_once('../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for empty fields
    $required_fields = ['user_name', 'email', 'pwd', 'street_name', 'street_nb', 'city', 'province', 'zip_code', 'country'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "The '$field' field is required.";
        }
    }

    if (!empty($errors)) {
        // Store errors in session and redirect
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit();
    }

    // Receive data from the form
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $street_name = $_POST['street_name'];
    $street_nb = $_POST['street_nb'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];

    // Hash the password
    $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);

    // Insert new user into the 'user' table using prepared statement
    $sql_user = "INSERT INTO `user` (`user_name`, `email`, `pwd`, `role_id`) 
                 VALUES (?, ?, ?, (SELECT `id` FROM `role` WHERE `name` = 'client'))";
    $stmt_user = mysqli_prepare($conn, $sql_user);
    mysqli_stmt_bind_param($stmt_user, 'sss', $user_name, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt_user)) {
        // Get the ID of the newly registered user
        $user_id = mysqli_insert_id($conn);

        // Insert address into the 'address' table using prepared statement
        $sql_address = "INSERT INTO `address` (`street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`)
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_address = mysqli_prepare($conn, $sql_address);
        mysqli_stmt_bind_param($stmt_address, 'sissss', $street_name, $street_nb, $city, $province, $zip_code, $country);

        if (mysqli_stmt_execute($stmt_address)) {
            // Get the ID of the newly registered address
            $address_id = mysqli_insert_id($conn);

            // Update the address ID in the 'user' table
            $sql_update_user = "UPDATE `user` SET `billing_address_id` = ?, `shipping_address_id` = ?
                                WHERE `id` = ?";
            $stmt_update_user = mysqli_prepare($conn, $sql_update_user);
            mysqli_stmt_bind_param($stmt_update_user, 'iii', $address_id, $address_id, $user_id);

            if (mysqli_stmt_execute($stmt_update_user)) {
                header("Location: profile.php");
            } else {
                echo "Error updating user with address ID: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting address: " . mysqli_error($conn);
        }

        // Close the address prepared statement
        mysqli_stmt_close($stmt_address);
    } else {
        echo "Error registering user: " . mysqli_error($conn);
    }

    // Close the user prepared statement
    mysqli_stmt_close($stmt_user);
} else {
    echo "Access not allowed";
}

// Close the database connection
mysqli_close($conn);
?>
