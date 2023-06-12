<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .product {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .product .name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product .description {
            margin-top: 5px;
        }
        .product .details {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php
    // Database connection settings
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "tvshop";

    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);

    // Get the maximum price from the query string
    if(!isset($_GET["maxprice"])){
        $maxPrice=1000000000;
    }
    else{
        $maxPrice=$_GET["maxprice"];
    }
    if(isset($_GET["cat_id"])){
    $catId=$_GET["cat_id"];
    }
    if(isset($maxPrice)){
    $query = "SELECT * FROM products WHERE price < :max_price  AND status = 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':max_price', $maxPrice, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    if(isset($catId)){
        $query = "SELECT * FROM products WHERE category_id = :cat_id  AND status = 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cat_id', $catId, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    if(isset($catId) and isset($maxPrice)){
        $query = "SELECT * FROM products WHERE category_id = :cat_id AND price < :max_price AND status = 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cat_id', $catId, PDO::PARAM_INT);
        $stmt->bindParam(':max_price', $maxPrice, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Retrieve products with price less than the maximum price
   

    if ($products) {
        echo '<h1>Product List</h1>';

        foreach ($products as $product) {
            $id = $product['product_id'];
            $name = htmlspecialchars($product['product_name']);
            $description = htmlspecialchars($product['description']);
            $category = htmlspecialchars($product['category_id']);
            $price = htmlspecialchars($product['price']);
            $dimension = htmlspecialchars($product['dimension']);
            $brand = htmlspecialchars($product['brand']);
            $model = htmlspecialchars($product['model']);
            $displayTechnology = htmlspecialchars($product['display_technology']);
            $resolution = htmlspecialchars($product['resolution']);
            $refreshRate = htmlspecialchars($product['refresh_rate']);
            $smartTV = $product['smart_tv'] ? 'Yes' : 'No';

            echo '<div class="product">';
            echo '<div class="name"><a href="product.php?id=' . $id . '">' . $name . '</a></div>';
            echo '<div class="description">' . $description . '</div>';
            echo '<div class="details">';
            echo 'Category: ' . $category . '<br>';
            echo 'Price: $' . $price . '<br>';
            echo 'Dimension: ' . $dimension . '<br>';
            echo 'Brand: ' . $brand . '<br>';
            echo 'Model: ' . $model . '<br>';
            echo 'Display Technology: ' . $displayTechnology . '<br>';
            echo 'Resolution: ' . $resolution . '<br>';
            echo 'Refresh Rate: ' . $refreshRate . ' Hz<br>';
            echo 'Smart TV: ' . $smartTV . '<br>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found with a price less than ' . $maxPrice . '</p>';
    }
    ?>

</body>
</html>
