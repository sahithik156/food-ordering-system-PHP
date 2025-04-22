<?php
include 'config.php';
// Include the database configuration to connect to MySQL

session_start();
// Start the session to use session variables

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the logged-in user is an admin
$user_id = $_SESSION['user_id'];
$check_admin = $conn->query("SELECT is_admin FROM users WHERE id = $user_id");
$row = $check_admin->fetch_assoc();

if (!$row || $row['is_admin'] != 1) {
    // If user is not an admin, redirect to access denied page
    header("Location: access-denied.php");
    exit();
}
?>






<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - All Orders</title>
  <!-- Set the browser tab title -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Include Bootstrap CSS for styling -->
</head>

<body class="bg-light">
<!-- Light background for the body -->

<div class="container mt-5">
  <!-- Bootstrap container with top margin -->

  <h2 class="mb-4">📦 All Orders</h2>
  <!-- Heading for the orders table -->

  <?php
  // ✅ Query to fetch all order details including customer and food info
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
  // Execute the query and store the result

  if ($result->num_rows > 0): 
  // ✅ If there are any orders, display them in a table
  ?>
    <table class="table table-bordered table-striped">
      <!-- Bootstrap styled table with borders and stripes -->

      <thead class="table-dark">
        <!-- Table header with dark background -->
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
        <!-- Loop through each order row -->
        <tr>
          <td><?php echo $row['order_id']; ?></td>
          <!-- Show order ID -->

          <td><?php echo $row['customer_name']; ?></td>
          <!-- Show customer name -->

          <td><?php echo $row['food_name']; ?></td>
          <!-- Show food item name -->

          <td><?php echo $row['quantity']; ?></td>
          <!-- Show quantity -->

          <td><?php echo date("F j, Y, g:i a", strtotime($row['order_date'])); ?></td>
          <!-- Format and show order date -->
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  <?php else: ?>
    <!-- If no orders exist -->
    <p>No orders found.</p>
  <?php endif; ?>
</div>

</body>
</html>
