<?php
include 'config.php';
session_start();

// 🔁 If already logged in, send to homepage
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>



<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">User Login</h2>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $sql = "SELECT * FROM users WHERE email='$email'";
      $result = $conn->query($sql);

      if ($result->num_rows == 1) {
          $row = $result->fetch_assoc();
          if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
        
            echo "<div class='alert alert-success'>Login successful! Redirecting...</div>";
        
            if ($row['is_admin'] == 1) {
                echo "<script>setTimeout(() => { window.location.href='admin-home.php'; }, 1500);</script>";
            } else {
                echo "<script>setTimeout(() => { window.location.href='index.php'; }, 1500);</script>";
            }
        
          } else {
              echo "<div class='alert alert-danger'>Incorrect password.</div>";
          }
      } else {
        echo "<div class='alert alert-warning'>
                Email not found. <a href='register.php' class='btn btn-sm btn-outline-primary ms-2'>Register here</a>
              </div>";
       }
    }
      
  
  ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>
<p class="mt-3">Don't have an account? <a href="register.php">Register Now</a></p>

</body>
</html>
