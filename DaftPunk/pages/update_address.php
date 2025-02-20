<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "checkout"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-address'])) {
    $oldAddress = htmlspecialchars($_POST['old-address']);
    $newAddress = htmlspecialchars($_POST['new-address']);
    $cvc = htmlspecialchars($_POST['cvc']);

    $stmt = $conn->prepare("SELECT orderID FROM CheckoutInfo WHERE custAddress = ? AND cvc = ?");
    if ($stmt === false) {
        die("SQL Failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $oldAddress, $cvc);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $updateStmt = $conn->prepare("UPDATE CheckoutInfo SET custAddress = ? WHERE custAddress = ? AND cvc = ?");
        if ($updateStmt === false) {
            die("SQL Failed: " . $conn->error);
        }

        $updateStmt->bind_param("sss", $newAddress, $oldAddress, $cvc);

        if ($updateStmt->execute()) {
            echo "Your Address is Updated in our Systems."; 
        } else {
            echo "Error updating address: " . $updateStmt->error;
        }

        $updateStmt->close();
    } else {
        echo "Your Request could not be completed. Please re-check your input and try again.";
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
    <title>Update Your Address</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../scripts/mobile-nav.js" defer></script>
    <script src="../scripts/theme-toggle.js" defer></script>
    <script src="../scripts/validation.js" defer></script>
</head>
<body>
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
        <li><button id="theme-toggle" class="theme-btn">Dark Mode</button></li>
      </ul>
    </nav>
</header>

<div class="update-container">
    <div class="update-box">
      <h2>Update Address</h2>
      <p>If you mistakenly entered the wrong address on payment, its not a problem, you can update it here with this form.</p>
      <form action="update_address.php" method="POST">
      <div class="form-group">
          <label for="cvc">CVC</label>
          <input type="text" id="cvc" name="cvc" placeholder="Enter your card's CVC" required>
        </div>
        <div class="form-group">
          <label for="old-address">Old Address</label>
          <input type="text" id="old-address" name="old-address" placeholder="Enter your old address" required>
        </div>
        <div class="form-group">
          <label for="new-address">New Address</label>
          <input type="text" id="new-address" name="new-address" placeholder="Enter your new address" required>
        </div>
        <button type="submit" name="update-address" class="submit-btn">Update</button>
        <button type="reset" class="clear-btn">Clear</button>
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
