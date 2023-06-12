<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
</head>
<body>
    <h1>Delete Product</h1>

    <?php
    // Check if the product_id is provided in the query string
    if (empty($_GET['pid'])) {
        echo "Product ID not provided.";
        exit;
    }

    $productId = $_GET['pid'];

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

    // Prepare and execute the SQL query to soft delete the product
    $sql = "UPDATE products SET status = 0 WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Product deleted successfully.";
    } else {
        echo "Failed to delete the product.";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
