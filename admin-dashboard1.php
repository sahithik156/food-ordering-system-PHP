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
    header("Location: access-denied.php");
    exit();

}
?>
<?php

// Optional: admin-only access check
// if ($_SESSION['user_name'] !== 'admin') { header("Location: index.php"); exit(); }

// Calculate stats
$today = date("Y-m-d");
$this_week = date("Y-m-d", strtotime("-7 days"));

// Total orders today
$today_sql = "SELECT COUNT(*) AS total_today FROM orders WHERE DATE(order_date) = '$today'";
$today_result = $conn->query($today_sql);
$today_orders = $today_result->fetch_assoc()['total_today'];

// Total orders this week
$week_sql = "SELECT COUNT(*) AS total_week FROM orders WHERE DATE(order_date) >= '$this_week'";
$week_result = $conn->query($week_sql);
$week_orders = $week_result->fetch_assoc()['total_week'];

// Most ordered item
$top_sql = "SELECT food_items.name, SUM(orders.quantity) AS total
            FROM orders
            JOIN food_items ON orders.food_id = food_items.id
            GROUP BY food_items.name
            ORDER BY total DESC
            LIMIT 1";
$top_result = $conn->query($top_sql);
$top_item = $top_result->num_rows > 0 ? $top_result->fetch_assoc() : null;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
      padding: 20px;
    }
    .sidebar h4 {
      color: #ffc107;
    }
    .sidebar a {
      display: block;
      padding: 10px 0;
      color: white;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .content {
      flex: 1;
      padding: 30px;
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <h4>🍔 Food Admin</h4>
  <a href="admin-dashboard.php">Dashboard</a>
  <a href="admin.php">View Orders</a>
  <a href="logout.php">Logout</a>
</div>

<div class="content">
  <h2>📊 Dashboard</h2>
  <div class="row mt-4">
    <div class="col-md-4">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Orders Today</h5>
          <p class="card-text fs-3"><?php echo $today_orders; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Orders This Week</h5>
          <p class="card-text fs-3"><?php echo $week_orders; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-warning mb-3">
        <div class="card-body">
          <h5 class="card-title">Top Item</h5>
          <p class="card-text fs-5">
            <?php 
              if ($top_item) {
                echo $top_item['name'] . " (" . $top_item['total'] . " orders)";
              } else {
                echo "No orders yet.";
              }
            ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html> 