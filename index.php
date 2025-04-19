<?php include 'config.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>


<div class="container mt-5">
  <h2>Available Food Items</h2>
  <div class="row">
    <?php
      $sql = "SELECT * FROM food_items";
      $result = $conn->query($sql);

      while ($row = $result->fetch_assoc()) {
    ?>
      <div class="col-md-4">
        <div class="card mb-3">
          <img src="img/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['name']; ?></h5>
            <p class="card-text"><?php echo $row['description']; ?></p>
            <p class="card-text"><strong>$<?php echo number_format($row['price'], 2); ?></strong></p>
            <a href="order.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Order Now</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
