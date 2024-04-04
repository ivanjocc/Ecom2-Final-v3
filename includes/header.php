<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="../public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        nav ul li a:hover {
            color: #ff9900;
        }

        #logo img {
            max-width: 80px;
            height: auto;
            border-radius: 50px;
        }
    </style>
</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="views/auth/register.php">Register</a></li>
                <li><a href="views/auth/login.php">Login</a></li>
                <li><a href="views/auth/profile.php">Profile</a></li>
                <li> <a href="views/order/view_cart.php">Cart</a></li>
            </ul>
        </nav>
        <div id="logo">
            <a href="index.php">
                <img src="public/images/logo.png" alt="Logo">
            </a>
        </div>
    </header>
</body>

</html>