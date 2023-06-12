<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are provided
    if (empty($_POST['product_name']) || empty($_POST['description']) || empty($_POST['price'])) {
        echo "Please fill in all the required fields.";
        exit;
    }

    // Sanitize and retrieve the form data
    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $dimension = $_POST['dimension'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $displayTechnology = $_POST['display_technology'];
    $resolution = $_POST['resolution'];
    $refreshRate = $_POST['refresh_rate'];
    $smartTV = isset($_POST['smart_tv']) ? 1 : 0;

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

    // Prepare and execute the SQL query to insert the new product
    $sql = "INSERT INTO products (product_name, description, price, category_id, dimension, brand, model, display_technology, resolution, refresh_rate, smart_tv) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsssssis", $productName, $description, $price, $category, $dimension, $brand, $model, $displayTechnology, $resolution, $refreshRate, $smartTV);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Product created successfully.";
    } else {
        echo "Failed to create the product.";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
</head>
<body>
    <h1>Create Product</h1>
    <form action="" method="post">
        <div>
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>
        <div>
            <label for="category">Category:</label>
            <input type="text" id="category" name="category">
        </div>
        <div>
            <label for="dimension">Dimension:</label>
            <input type="text" id="dimension" name="dimension">
        </div>
        <div>
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand">
        </div>
        <div>
            <label for="model">Model:</label>
            <input type="text" id="model" name="model">
        </div>
        <div>
            <label for="display_technology">Display Technology:</label>
            <input type="text" id="display_technology" name="display_technology">
        </div>
        <div>
            <label for="resolution">Resolution:</label>
            <input type="text" id="resolution" name="resolution">
        </div>
        <div>
            <label for="refresh_rate">Refresh Rate:</label>
            <input type="text" id="refresh_rate" name="refresh_rate">
        </div>
        <div>
            <label for="smart_tv">Smart TV:</label>
            <input type="checkbox" id="smart_tv" name="smart_tv" value="1">
        </div>
        <button type="submit">Create</button>
    </form>
</body>
</html>
