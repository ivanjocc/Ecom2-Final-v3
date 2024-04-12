<?php

require_once __DIR__ . '/../../controller/UserController.php';
require_once __DIR__ . '/../../config/connexionDB.php';

$db = connexionDB::getConnection();
$userController = new UserController($db);

// Llamar método
$userController->listUsers();

$users = $userController->users;

?>

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

		th, td {
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

		.delete-btn {
			color: #FF0000;
			border: none;
			background: none;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<h2>User List</h2>
	<table>
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Email</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Action</th>
		</tr>
		<?php foreach ($users as $user) : ?>
		<tr>
			<td><?= htmlspecialchars($user['id']) ?></td>
			<td><?= htmlspecialchars($user['user_name']) ?></td>
			<td><?= htmlspecialchars($user['email']) ?></td>
			<td><?= htmlspecialchars($user['fname']) ?></td>
			<td><?= htmlspecialchars($user['lname']) ?></td>
			<td>
				<form action="delete_user.php" method="POST">
					<input type="hidden" name="user_id" value="<?= $user['id'] ?>">
					<button type="submit" class="delete-btn">Delete</button>
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>
