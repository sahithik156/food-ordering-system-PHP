<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <!-- Page title in browser tab -->

  <!-- Bootstrap 5 CSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<!-- Light gray background -->

<div class="container mt-5">
  <!-- Bootstrap container with top margin -->
  <h2 class="mb-4">User Registration</h2>
  <!-- Page header -->
  <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // When form is submitted with POST

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Hash the password for secure storage

    // 🔎 Check if email is already registered
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        // If email already exists
        echo "<div class='alert alert-warning'>Email already registered.</div>";
    } else {
        // ✅ Insert new user into database
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
    <!-- Form submits to the same page -->
    
    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input type="text" class="form-control" name="name" required>
      <!-- User full name input -->
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" name="email" required>
      <!-- User email input -->
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" required>
      <!-- User password input -->
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
    <!-- Register button -->
  </form>
</div>

</body>
</html>
