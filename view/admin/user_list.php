<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            text-decoration: none;
            text-align: center;
            color: #007BFF;
            display: block;
            margin-top: 10px;
            padding: 8px;
            background-color: #fff;
            border: 1px solid #007BFF;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #007BFF;
            color: #fff;
        }
    </style>

</head>

<body>
    <h2>User List</h2>
    <a href="./dashboard.php">Dashboard</a>

    <?php
    // Connect to the database (adjust the path based on your file structure)
    require_once('../../config/database.php');

    // Query to get the list of users using prepared statement
    $sql = "SELECT `id`, `user_name`, `email` FROM `user`";
    $stmt = mysqli_prepare($conn, $sql);

    // Execute the prepared statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Bind the result variables
        mysqli_stmt_bind_result($stmt, $user_id, $user_name, $email);

        // Display the list of users
        echo "<table border='1'>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>";

        while (mysqli_stmt_fetch($stmt)) {
            echo "<tr>
                    <td>{$user_id}</td>
                    <td>{$user_name}</td>
                    <td>{$email}</td>
                    <td><a href='upgrade_user.php?user_id={$user_id}'>Admin</a>  <a href='delete_user.php?user_id={$user_id}'>Delete</a></td>
                </tr>";
        }

        echo "</table>";

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>
