<?php

function connexionDB()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpassword = "";
    $dbname = "petshop";

    $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

    if (!$conn) {
        die("There is a problem => " . mysqli_connect_error());
    }

    return $conn;
}

$conn = connexionDB();

?>
