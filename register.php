<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">User Registration</h2>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // Check if email already exists
      $check = "SELECT * FROM users WHERE email='$email'";
      $result = $conn->query($check);

      if ($result->num_rows > 0) {
          echo "<div class='alert alert-warning'>Email already registered.</div>";
      } else {
          $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
          if ($conn->query($sql) === TRUE) {
              echo "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login here</a></div>";
          } else {
              echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
          }
      }
  }
  ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input type="text" class="form-control" name="name" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>

</body>
</html>
