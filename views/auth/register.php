<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
            color: #2a78ad;
        }
    </style>
</head>

<body>
    <h2>User Registration</h2>
    <form action="process_register.php" method="post">
        <!-- Fields for the 'user' table -->
        <label for="user_name">Username:</label>
        <input type="text" name="user_name">
        <?php if (isset($_SESSION['errors']['user_name'])) echo "<p style='color:red'>{$_SESSION['errors']['user_name']}</p>"; ?>
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email">
        <?php if (isset($_SESSION['errors']['email'])) echo "<p style='color:red'>{$_SESSION['errors']['email']}</p>"; ?>
        <br>

        <label for="pwd">Password:</label>
        <input type="password" name="pwd">
        <?php if (isset($_SESSION['errors']['pwd'])) echo "<p style='color:red'>{$_SESSION['errors']['pwd']}</p>"; ?>
        <br>

        <!-- Additional fields for the 'address' table -->
        <label for="street_name">Street Name:</label>
        <input type="text" name="street_name">
        <?php if (isset($_SESSION['errors']['street_name'])) echo "<p style='color:red'>{$_SESSION['errors']['street_name']}</p>"; ?>
        <br>

        <label for="street_nb">Street Number:</label>
        <input type="text" name="street_nb">
        <?php if (isset($_SESSION['errors']['street_nb'])) echo "<p style='color:red'>{$_SESSION['errors']['street_nb']}</p>"; ?>
        <br>

        <label for="city">City:</label>
        <input type="text" name="city">
        <?php if (isset($_SESSION['errors']['city'])) echo "<p style='color:red'>{$_SESSION['errors']['city']}</p>"; ?>
        <br>

        <label for="province">Province:</label>
        <input type="text" name="province">
        <?php if (isset($_SESSION['errors']['province'])) echo "<p style='color:red'>{$_SESSION['errors']['province']}</p>"; ?>
        <br>

        <label for="zip_code">Zip Code:</label>
        <input type="text" name="zip_code" maxlength="6">
        <?php if (isset($_SESSION['errors']['zip_code'])) echo "<p style='color:red'>{$_SESSION['errors']['zip_code']}</p>"; ?>
        <br>

        <label for="country">Country:</label>
        <input type="text" name="country">
        <?php if (isset($_SESSION['errors']['country'])) echo "<p style='color:red'>{$_SESSION['errors']['country']}</p>"; ?>
        <br>

        <input type="submit" value="Register">
        <a href="../../index.php">Home</a>

        <?php
        // Display global error messages if they exist
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo "<p style='color:red'>$error</p>";
        }
        
        // Clear errors from the session
        unset($_SESSION['errors']);
        ?>
    </form>
</body>

</html>