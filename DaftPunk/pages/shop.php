<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "checkout"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-payment'])) {

    $orderID = htmlspecialchars($_POST['order-id']);
    $cvc = htmlspecialchars($_POST['cvc']);

    $stmt = $conn->prepare("DELETE FROM CheckoutInfo WHERE orderID = ? AND cvc = ?");
    if ($stmt === false) {
        die("SQL preparation failed: " . $conn->error);
    }
    $stmt->bind_param("is", $orderID, $cvc);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "Your Data has been removed from our systems.";
    } else {
        echo "Error: No matching record found.";
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
  <title>Daft Punk Merchandise</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../scripts/mobile-nav.js" defer></script>
  <script src="../scripts/theme-toggle.js" defer></script>
  <script src="../scripts/product-cart.js" defer></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@400;700&display=swap" rel="stylesheet">
</head>

<body id="top">
  <header class="page-header">
    <a href="../index.php" class="page-logo">
      <img src="../images/logo.png" alt="Page Logo - John3 TopPNG">
    </a>
    <a href="javascript:;" class="mobile-btn" id="nav-btn">
      <img src="../images/nav-button.png" alt="Mobile navigation reveal button">
    </a>
    <div>
      <nav class="page-navigation" id="nav-list">
        <ul class="navigation-list">
          <li><a href="../index.php">Home</a></li>
          <li><a href="about.php">History</a></li>
          <li><a href="music.php">Music</a></li>
          <li><a href="dates.php">Tour Dates</a></li>
          <li><a href="shop.php">Store</a></li>
          <li><a href="recent-orders.php">Recent Orders</a></li>
          <li><button id="theme-toggle" class="theme-btn">Dark Mode</button></li>
          <li><a href="javascript:;" class="cart-btn" id="cart-btn">Cart (<span id="cart-count">0</span>)</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="page-content">
    <div class="hero3"></div>
    <div class="about-heading">
      <h1>Official Merchandise</h1>
      <p>Get your hands on exclusive Daft Punk merch!</p>
      <p style="text-decoration: underline; font-style: italic;">All Prices are including Tax.</p>
    </div>

    <div class="delete-container">
    <div class="delete-box">
        <h2>Right To Erase</h2>
        <p>Under UK GDPR, you have the right to request the erasure of your personal data.</p>
        <button type="button" class="collapsible">Toggle Form</button>
        <div class="form-container">

            <form action="shop.php" method="POST">
                <div class="form-group">
                    <label for="order-id">Order ID</label>
                    <input type="number" id="order-id" name="order-id" placeholder="Order Number" required>
                </div>
                <div class="form-group">
                    <label for="cvc">CVC</label>
                    <input type="text" id="cvc" name="cvc" placeholder="123" required>
                </div>
                <button type="submit" name="delete-payment" class="submit-btn">Erase</button>
                <button type="reset" class="btn-reset">Clear</button>
            </form>
        </div>
    </div>
</div>

    <div id="cart-modal" style="display: none;">
      <div id="cart-container">
        <h2>Your Cart</h2>
        <ul id="cart-items"></ul>
        <p id="cart-total">Total: £0.00</p>
        <button id="clear-cart-btn" onclick="clearCart()">Clear Cart</button>
        <button id="checkout-btn">Proceed to Checkout</button>
        <button id="close-cart-btn">X</button>
      </div>
    </div>

    <div class="content-section merch-section">
      <div class="merch-grid">
        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store01-dptee.png" alt="Daft Punk Red Logo Tee" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Punk Black Tee</h2>
            <p class="merch-description">Retro Daft Punk Tee, LA-made, soft, garment-dyed.</p>
            <p class="merch-price">£35.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk Black Tee', 35.00)">Add to Cart</button>
          </div>
        </div>

        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store02-dphoodie.png" alt="Daft Punk Red Logo Hoodie" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Punk Black Hoodie</h2>
            <p class="merch-description">Heavyweight Daft Punk hoodie, warm, durable, stylish & LA-made.</p>
            <p class="merch-price">£70.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk Black Hoodie', 70.00)">Add to Cart</button>
          </div>
        </div>

        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store03-sweatshorts.png" alt="Daft Punk Red Logo Sweatshorts" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Punk Black Sweatshorts</h2>
            <p class="merch-description">Daft Punk sweatshorts, comfy fleece, logo, pockets & adjustable fit.</p>
            <p class="merch-price">£40.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk Black Sweatshorts', 40.00)">Add to Cart</button>
          </div>
        </div>

        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store09-blacksweatpants.png" alt="Daft Punk Red Logo Sweatpants" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Punk Red Logo Sweatpants</h2>
            <p class="merch-description">Daft Punk sweatshorts, comfy fleece, logo, pockets & adjustable fit.</p>
            <p class="merch-price">£45.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk Sweatpants', 45.00)">Add to Cart</button>
          </div>
        </div>

        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store07-whitetee.png" alt="Daft Punk White Tee" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Punk White Tee</h2>
            <p class="merch-description">Daft Punk t-shirt with bold logo, retro 90s style, 100% cotton, unique
              garment-dyed finish.</p>
            <p class="merch-price">£35.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk White Tee', 35.00)">Add to Cart</button>
          </div>
        </div>

        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store08-greycrewneck.png" alt="Daft Punk Grey Crewneck" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Punk Grey Crewneck</h2>
            <p class="merch-description">Daft Punk crewneck sweatshirt with logo, cozy, oversized, durable premium
              fabric.</p>
            <p class="merch-price">£60.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk Grey Crewneck', 60.00)">Add to Cart</button>
          </div>
        </div>

        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store04-clubtee.png" alt="Daft Club Tee" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Club Black Tee</h2>
            <p class="merch-description">Daft Club Logo Tee with bold graphics, comfort, and style.</p>
            <p class="merch-price">£35.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk Black Tee', 35.00)">Add to Cart</button>
          </div>
        </div>

        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store05-clubhoodie.png" alt="Daft Club Hoodie" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Club Black Hoodie</h2>
            <p class="merch-description">Heavyweight hoodie with red Daft Club logo, durable U.S. cotton, pre-washed for
              perfect fit.</p>
            <p class="merch-price">£70.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk Black Hoodie', 70.00)">Add to Cart</button>
          </div>
        </div>

        <div class="merch-item">
          <div class="merch-image">
            <img src="../images/store06-clubhat.png" alt="Daft Club Black Hat" />
          </div>
          <div class="merch-content">
            <h2 class="merch-title">Daft Club Black Hat</h2>
            <p class="merch-description">Elevate your style with this snapback hat, featuring a stitched Daft Club logo
              for a bold, iconic look.</p>
            <p class="merch-price">£20.00</p>
            <button class="btn-primary" onclick="addToCart('Daft Punk Black Hat', 20.00)">Add to Cart</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="page-footer">
    <div class="footer-content">
      <a href="#top">Back to Top</a>
      <p>Daft Punk &copy;1993-2025</p>
      <ul class="footer-links">
      </ul>
    </div>
  </footer>
</body>

</html>