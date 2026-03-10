<?php

$host = "localhost";
$db = "recipe_db";
$user = "root";
$pass = "root";

$conn = mysqli_connect($host, $user, $pass, $db, 8889);

$error = mysqli_connect_error();

if ($error != null) {
    die("Connection failed: " . $conn->connect_error);
}
 else {
    echo 'success!';
 }
?>
