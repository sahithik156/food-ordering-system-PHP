<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if admin
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT is_admin FROM users WHERE id = $user_id");
$row = $result->fetch_assoc();

if (!$row || $row['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #4e54c8, #8f94fb);
      color: white;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      background: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 15px;
      backdrop-filter: blur(10px);
      text-align: center;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    }
    .btn {
      margin: 10px;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Welcome, Admin 👋</h2>
    <p class="mb-4">Choose an action below:</p>
    <a href="admin-dashboard.php" class="btn btn-warning px-4">📊 Dashboard</a>
    <a href="admin.php" class="btn btn-light px-4">📋 View Orders</a>
  </div>
</body>
</html>
