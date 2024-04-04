<?php
// Suponiendo que la información del usuario se almacena en una sesión después del inicio de sesión
session_start();

// Destruir todas las variables de sesión
session_destroy();

// Redirigir a la página de inicio de sesión
header("Location: login.php");
exit();
?>
