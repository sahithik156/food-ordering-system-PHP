<?php
$host = "localhost";
$user = "root";
$password = "Bts@2013";
$db = "food_order_db";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>