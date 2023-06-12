<!DOCTYPE html>
<html>
<head>
    <title>Soft Deleted Products</title>
</head>
<body>
    <h1>Soft Deleted Products</h1>

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

    // Check if a product ID is provided in the query string
    if (isset($_GET['pid'])) {
        $productID = $_GET['pid'];

        // Activate the product by setting its status to 1
        $updateQuery = "UPDATE products SET status = 1 WHERE product_id = $productID";
        if ($conn->query($updateQuery) === TRUE) {
            echo "Product activated successfully.";
        } else {
            echo "Error activating product: " . $conn->error;
        }
    }

    // Fetch soft deleted products
    $sql = "SELECT * FROM products WHERE status = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Product ID</th><th>Product Name</th><th>Activate</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["product_id"] . "</td>";
            echo "<td>" . $row["product_name"] . "</td>";
            echo "<td><a href='?pid=" . $row["product_id"] . "'>Activate</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No soft deleted products found.";
    }

    $conn->close();
    ?>
</body>
</html>
