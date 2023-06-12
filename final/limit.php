<?php
// Connect to the database (replace with your own database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tvshop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the count from the query string
$count = isset($_GET['c']) ? intval($_GET['c']) : 3;

// Fetch the products
$sql = "SELECT * FROM products ORDER BY price ASC LIMIT $count";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cheapest Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        li strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Cheapest Products</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>Product ID:</strong> " . $row["product_id"] . "</li>";
            echo "<li><strong>Product Name:</strong> " . $row["product_name"] . "</li>";
            echo "<li><strong>Price:</strong> $" . $row["price"] . "</li>";
            echo "<li><strong>Description:</strong> " . $row["description"] . "</li>";
            echo "<br>";
        }
        echo "</ul>";
    } else {
        echo "<p>No products found.</p>";
    }
    ?>

    <?php
    $conn->close();
    ?>
</body>
</html>
