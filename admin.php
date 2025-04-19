<?php
include 'config.php';
session_start();

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the logged-in user is an admin
$user_id = $_SESSION['user_id'];
$check_admin = $conn->query("SELECT is_admin FROM users WHERE id = $user_id");
$row = $check_admin->fetch_assoc();

if (!$row || $row['is_admin'] != 1) {
    // User is not an admin
    header("Location: access-denied.php");
    exit();
}
?>




<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - All Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">📦 All Orders</h2>

  <?php
  $sql = "SELECT 
            orders.id AS order_id,
            users.name AS customer_name,
            food_items.name AS food_name,
            orders.quantity,
            orders.order_date
          FROM orders
          JOIN users ON orders.user_id = users.id
          JOIN food_items ON orders.food_id = food_items.id
          ORDER BY orders.order_date DESC";

  $result = $conn->query($sql);

  if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Food Item</th>
          <th>Quantity</th>
          <th>Ordered At</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['order_id']; ?></td>
          <td><?php echo $row['customer_name']; ?></td>
          <td><?php echo $row['food_name']; ?></td>
          <td><?php echo $row['quantity']; ?></td>
          <td><?php echo date("F j, Y, g:i a", strtotime($row['order_date'])); ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No orders found.</p>
  <?php endif; ?>
</div>

</body>
</html>
