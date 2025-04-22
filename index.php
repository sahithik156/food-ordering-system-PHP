<?php include 'config.php'; ?> 
<!-- Include the database configuration (connects to MySQL) -->

<?php include 'includes/header.php'; ?> 
<!-- Include the header file (contains HTML <head>, navigation bar, etc.) -->

<?php
session_start(); 
// Start PHP session to keep track of logged-in users

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// If the user is not logged in, redirect them to login page
?>

<!-- Begin HTML Content -->
<!DOCTYPE html>
<html>
<head>
  <title>Food Ordering System</title>
  <!-- Page title shown in the browser tab -->

  <!-- Bootstrap CSS link for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Bootstrap container to center and space content -->
<div class="container mt-5">
  <h2>Available Food Items</h2>
  <!-- Heading for the list of food items -->

  <div class="row">
    <!-- Start Bootstrap row for responsive columns -->

    <?php
      $sql = "SELECT * FROM food_items"; 
      // SQL query to fetch all food items from the database

      $result = $conn->query($sql); 
      // Execute the query and store results in $result

      while ($row = $result->fetch_assoc()) {
        // Loop through each food item in the result
    ?>
      <div class="col-md-4">
        <!-- Create a column that takes up 4/12 width on medium+ screens -->

        <div class="card mb-3">
          <!-- Bootstrap card to display the food item -->

          <img src="img/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
          <!-- Food image (stored in /img/ folder) -->

          <div class="card-body">
            <!-- Body of the card with food info -->

            <h5 class="card-title"><?php echo $row['name']; ?></h5>
            <!-- Food item name -->

            <p class="card-text"><?php echo $row['description']; ?></p>
            <!-- Description of the food item -->

            <p class="card-text"><strong>$<?php echo number_format($row['price'], 2); ?></strong></p>
            <!-- Price of the food item (formatted as $0.00) -->

            <a href="order.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Order Now</a>
            <!-- Button to order the food item; sends ID to order.php -->
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?> 
<!-- Include footer HTML from a separate file (optional copyright) -->

<!-- Bootstrap JS for interactivity (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
