<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "checkout"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-payment'])) {
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $cardNumber = htmlspecialchars($_POST['card-number']);
    $expiryDate = htmlspecialchars($_POST['expiry-date']);
    $cvc = htmlspecialchars($_POST['cvc']);

    $cardNumber = str_replace(' ', '', $cardNumber); 

    $stmt = $conn->prepare("INSERT INTO CheckoutInfo (custName, custAddress, custCard, expiry_date, cvc, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    if ($stmt === false) {
        die("SQL preparation failed: " . $conn->error);
    }
    $stmt->bind_param("sssss", $name, $address, $cardNumber, $expiryDate, $cvc);

    if ($stmt->execute()) {
        $orderID = $stmt->insert_id; 

        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        if (!$cart || !is_array($cart)) {
            die("Error: Cart is empty or invalid.");
        }

        $productStmt = $conn->prepare("INSERT INTO order_products (orderID, productName, productQuantity, productPrice) VALUES (?, ?, ?, ?)");
        if ($productStmt === false) {
            die("SQL preparation failed: " . $conn->error);
        }

        foreach ($cart as $item) {
            $quantity = isset($item['quantity']) ? $item['quantity'] : 1; 
            $productStmt->bind_param("isid", $orderID, $item['name'], $quantity, $item['price']);
            if (!$productStmt->execute()) {
                die("Failed to insert product: " . $productStmt->error);
            }
        }

        $productStmt->close();

        setcookie("cart", "", time() - 3600, "/");

        header("Location: ordercomplete.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../scripts/mobile-nav.js" defer></script>
  <script src="../scripts/theme-toggle.js" defer></script>
  <script src="../scripts/validation.js" defer></script>
</head>
<body id="top">
  <header class="page-header">
    <a href="index.php" class="page-logo">
      <img src="../images/logo.png" alt="Page Logo - John3 TopPNG">
    </a>
    <a href="javascript:;" class="mobile-btn" id="nav-btn">
      <img src="../images/nav-button.png" alt="Mobile navigation reveal button">
    </a>
    <nav class="page-navigation" id="nav-list">
      <ul class="navigation-list">
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">History</a></li>
        <li><a href="music.php">Music</a></li>
        <li><a href="dates.php">Tour Dates</a></li>
        <li><a href="shop.php">Store</a></li>
        <li><a href="update_address.php">Update Address</a></li>
        <li><button id="theme-toggle" class="theme-btn">Dark Mode</button></li>
      </ul>
    </nav>
  </header>

  <div class="payment-container">
    <div class="payment-box">
      <h2>Payment Details</h2>
      <form action="checkout.php" method="POST">
        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" placeholder="John Doe" required>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" id="address" name="address" placeholder="123 Main St, City, Country" required>
        </div>
        <div class="form-group">
          <label for="card-number">Card Number</label>
          <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" required>
        </div>
        <div class="form-group">
          <label for="expiry-date">Expiry Date</label>
          <input type="month" id="expiry-date" name="expiry-date" placeholder="Format: 01 01" required>
        </div>
        <div class="form-group">
          <label for="cvc">CVC</label>
          <input type="text" id="cvc" name="cvc" placeholder="123" required>
        </div>
        <button type="submit" name="submit-payment" class="submit-btn">Pay Now</button>
        <button type="reset" class="btn-reset">Clear</button>
      </form>
    </div>
  </div>

  <footer class="page-footer">
    <div class="footer-content">
      <a href="#top">Back to Top</a>
      <p>Daft Punk &copy;1993-2025</p>
    </div>
  </footer>
</body>
</html>
