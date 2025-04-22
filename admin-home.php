<?php
include 'config.php';
// Include database connection settings

session_start();
// Start the session to access user data

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ Check if the logged-in user is an admin
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT is_admin FROM users WHERE id = $user_id");
$row = $result->fetch_assoc();

if (!$row || $row['is_admin'] != 1) {
    // If not an admin, redirect to normal homepage
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Admin Home</title>
  <!-- Page title for browser tab -->

  <!-- Bootstrap CSS CDN for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Internal CSS styles for the admin welcome card -->
  <style>
    body {
      background: linear-gradient(to right, #4e54c8, #8f94fb);
      /* Smooth gradient background */

      color: white;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
      /* Center card and apply clean font */
    }

    .card {
      background: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 15px;
      backdrop-filter: blur(10px);
      text-align: center;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
      /* Glass-like card with blur and shadow */
    }

    .btn {
      margin: 10px;
      /* Space between buttons */
    }
  </style>
</head>

<body>
  <div class="card">
    <!-- Welcome message with actions for admin -->
    <h2>Welcome, Admin 👋</h2>
    <p class="mb-4">Choose an action below:</p>

    <!-- Button to go to admin dashboard page (with stats) -->
    <a href="admin-dashboard.php" class="btn btn-warning px-4">📊 Dashboard</a>

    <!-- Button to go to view orders page -->
    <a href="admin.php" class="btn btn-light px-4">📋 View Orders</a>
  </div>
</body>
</html>
