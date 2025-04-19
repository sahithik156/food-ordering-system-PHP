<?php
$host = "localhost";
$user = "root";
$password = "Bts@2013"; // your MySQL password
$db = "food_order_db";  // your database name

$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Connected successfully to MySQL!";
?>
