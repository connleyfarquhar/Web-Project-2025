<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Orders</title>
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

<?php
// Database connection details
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "checkout"; // The name of the database being used

// Start the connection.
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful.
if ($conn->connect_error) {
    // If there's an error connecting stop and display the error message.
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve order information along with the product details.
$sql = "SELECT ci.orderID, ci.custName, ci.custAddress, ci.created_at,
               op.productName, op.productQuantity, op.productPrice
        FROM checkoutinfo ci
        JOIN order_products op ON ci.orderID = op.orderID
        ORDER BY ci.created_at DESC"; 

// Execute the query and store the result in the $result variable
$result = $conn->query($sql);

echo "<div class='orders-container'>"; 
echo "<div class='orders-box'>";       

// Check if there are any results from the query
if ($result->num_rows > 0) {
    $currentOrderID = null; 

    echo "<h1>Recent Orders</h1>"; 

    // Loop through each row returned by the SQL query
    while ($row = $result->fetch_assoc()) {

        if ($row['orderID'] !== $currentOrderID) {
            // If this is not the first order, close the previous order's list
            if ($currentOrderID !== null) echo "</ul>";
            
            // Update the current order ID to the new one from the database.
            $currentOrderID = $row['orderID'];
            
            echo "<strong>Order Receipt:</strong><ul class='product-details'>";
        }

        echo "<li>{$row['productName']} - £{$row['productPrice']}</li>";
    }

    echo "</ul></li>"; 
} else {
    // If there is no recent orders, the webpage will relay the following message.
    echo "<p>No recent orders found.</p>";
}

echo "</div>";
echo "</div>";

// Closes the connection from the database to the website.
$conn->close();
?>

<footer class="page-footer">
    <div class="footer-content">
      <a href="#top">Back to Top</a>
      <p>Daft Punk &copy;1993-2025</p>
    </div>
  </footer>
</body>
</html>
