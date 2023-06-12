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

    // Prepare and execute the SQL query to update the product
    $sql = "UPDATE products SET product_name = ?, description = ?, price = ?, category_id = ?, dimension = ?, brand = ?, model = ?, display_technology = ?, resolution = ?, refresh_rate = ?, smart_tv = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsssssisi", $productName, $description, $price, $category, $dimension, $brand, $model, $displayTechnology, $resolution, $refreshRate, $smartTV, $productId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Product updated successfully.";
    } else {
        echo "Failed to update the product.";
    }

    // Close the statement
    $stmt->close();
}

// Retrieve the product details from the database
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h1>Update Product</h1>
    <form action="" method="post">
        <div>
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $product['description']; ?></textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
        </div>
        <div>
            <label for="category">Category:</label>
            <select id="category" name="category">
                <option value="1" <?php if ($product['category_id'] == 1) echo 'selected'; ?>>TV</option>
                <option value="2" <?php if ($product['category_id'] == 2) echo 'selected'; ?>>Monitor</option>
            </select>
        </div>
        <div>
            <label for="dimension">Dimension:</label>
            <input type="text" id="dimension" name="dimension" value="<?php echo $product['dimension']; ?>">
        </div>
        <div>
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" value="<?php echo $product['brand']; ?>">
        </div>
        <div>
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" value="<?php echo $product['model']; ?>">
        </div>
        <div>
            <label for="display_technology">Display Technology:</label>
            <input type="text" id="display_technology" name="display_technology" value="<?php echo $product['display_technology']; ?>">
        </div>
        <div>
            <label for="resolution">Resolution:</label>
            <input type="text" id="resolution" name="resolution" value="<?php echo $product['resolution']; ?>">
        </div>
        <div>
            <label for="refresh_rate">Refresh Rate:</label>
            <input type="text" id="refresh_rate" name="refresh_rate" value="<?php echo $product['refresh_rate']; ?>">
        </div>
        <div>
            <label for="smart_tv">Smart TV:</label>
            <input type="checkbox" id="smart_tv" name="smart_tv" value="1" <?php if ($product['smart_tv'] == 1) echo 'checked'; ?>>
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>
