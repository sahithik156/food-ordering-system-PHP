


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

$today = date("Y-m-d");
$this_week = date("Y-m-d", strtotime("-7 days"));

$today_result = $conn->query("SELECT COUNT(*) AS total_today FROM orders WHERE DATE(order_date) = '$today'");
$today_orders = $today_result->fetch_assoc()['total_today'];

$week_result = $conn->query("SELECT COUNT(*) AS total_week FROM orders WHERE DATE(order_date) >= '$this_week'");
$week_orders = $week_result->fetch_assoc()['total_week'];

$top_result = $conn->query("SELECT food_items.name, SUM(orders.quantity) AS total FROM orders JOIN food_items ON orders.food_id = food_items.id GROUP BY food_items.name ORDER BY total DESC LIMIT 1");
$top_item = $top_result->num_rows > 0 ? $top_result->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      width: 220px;
      position: fixed;
      height: 100%;
      background-color: #343a40;
      padding-top: 20px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .content {
      margin-left: 240px;
      padding: 30px;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h4 class="text-center text-white mb-4">🍔 Admin Panel</h4>
    <a href="admin-dashboard.php">Dashboard</a>
    <a href="admin.php">View Orders</a>
    <a href="logout.php">Logout</a>
  </div>
  <div class="content">
    <h2 class="mb-4">📊 Dashboard Overview</h2>
    <div class="row">
      <div class="col-md-4">
        <div class="card text-white bg-success mb-4">
          <div class="card-body">
            <h5 class="card-title">Orders Today</h5>
            <h2><?php echo $today_orders; ?></h2>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-primary mb-4">
          <div class="card-body">
            <h5 class="card-title">Orders This Week</h5>
            <h2><?php echo $week_orders; ?></h2>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-warning mb-4">
          <div class="card-body">
            <h5 class="card-title">Top Item</h5>
            <p class="fs-5">
              <?php echo $top_item ? $top_item['name'] . " (" . $top_item['total'] . " orders)" : "No orders yet."; ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
