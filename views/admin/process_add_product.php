<?php
// Include the database configuration file
require_once('../../config/database.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the POST request
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle the image upload
    $targetDir = "../../public/img/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verify if the file is a JPG image
    if ($imageFileType != "jpg") {
        echo "Only JPG files are allowed.";
        exit();
    }

    // Move the file to the images folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert the new product into the database using prepared statement
        $imgPath = "public/img/" . basename($_FILES["image"]["name"]);
        $insertQuery = "INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`, `img_path`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sddsss", $name, $quantity, $price, $imgPath, $description, $targetFile);

        // Execute the prepared statement
        $result = mysqli_stmt_execute($stmt);

        // Check if the insertion was successful
        if ($result) {
            // Redirect to the dashboard after successful addition
            header("Location: dashboard.php");
        } else {
            // Display an error message if there's an issue with the database insertion
            echo "Error adding the product: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Display an error message if there's an issue with the image upload
        echo "Error uploading the image.";
    }
} else {
    // Display a message if access is not allowed
    echo "Access not allowed.";
}

// Close the database connection
mysqli_close($conn);
?>
