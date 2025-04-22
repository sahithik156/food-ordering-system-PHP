<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the food ID from the URL
$food_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the selected food item
$sql = "SELECT * FROM food_items WHERE id = $food_id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "Food item not found.";
    exit();
}

$food = $result->fetch_assoc();

// Handle form submission
$orderSuccess = false;
$quantity = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = intval($_POST['quantity']);
    $user_id = $_SESSION['user_id'];

    $insert = "INSERT INTO orders (user_id, food_id, quantity) VALUES ($user_id, $food_id, $quantity)";
    if ($conn->query($insert) === TRUE) {
        $orderSuccess = true;
    } else {
        echo "<div class='alert alert-danger'>Error placing order: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Order <?php echo $food['name']; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

  <?php if ($orderSuccess): ?>
    <div class="card bg-light p-4 mt-4">
      <h4 class="text-success"> Order Confirmed!</h4>
      <p><strong>Item:</strong> <?php echo $food['name']; ?></p>
      <p><strong>Quantity:</strong> <?php echo $quantity; ?></p>
      <p><strong>Total Price:</strong> $<?php echo number_format($food['price'] * $quantity, 2); ?></p>
      <p><strong>Order Time:</strong> <?php echo date("F j, Y, g:i a"); ?></p>
      <a href="index.php" class="btn btn-primary mt-2">Back to Home</a>
    </div>

  <?php else: ?>
    <h2>Order: <?php echo $food['name']; ?></h2>

    <div class="row">
      <div class="col-md-6">
        <img src="img/<?php echo $food['image']; ?>" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
      </div>
      <div class="col-md-6">
        <p><strong>Description:</strong> <?php echo $food['description']; ?></p>
        <p><strong>Price:</strong> $<?php echo number_format($food['price'], 2); ?></p>

        <form method="POST" oninput="calculateTotal()">
          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
          </div>

          <p><strong>Total Price:</strong> $<span id="totalPrice"><?php echo number_format($food['price'], 2); ?></span></p>

          <button type="submit" class="btn btn-success">Place Order</button>
          <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  <?php endif; ?>

</div>

<script>
  function calculateTotal() {
    let price = <?php echo $food['price']; ?>;
    let qty = document.getElementById("quantity").value;
    let total = (qty * price).toFixed(2);
    document.getElementById("totalPrice").textContent = total;
  }
</script>

</body>
</html>
