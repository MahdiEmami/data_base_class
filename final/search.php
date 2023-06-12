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

// Get the search name from the query string
$searchName = isset($_GET['s']) ? $_GET['s'] : '';

// Build the SQL query
if (!empty($searchName)) {
    $sql = "SELECT * FROM products WHERE product_name LIKE '%$searchName%'";
} else {
    $sql = "SELECT * FROM products";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Search</title>
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
    <h1>Product Search</h1>

    <form action="search.php" method="GET">
        <input type="text" name="s" placeholder="Search by product name" value="<?php echo $searchName; ?>">
        <input type="submit" value="Search">
    </form>

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