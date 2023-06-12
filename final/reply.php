<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tvshop";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the comment form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the parent ID from the query string
    $parentID = $_GET['pid'];
    $u_id = $_GET['uid'];
    $productID=$_GET['pr'];

    // Get the comment text from the form
    $commentText = $_POST['comment'];
    
    
    // Insert the reply comment into the database
    $sql = "INSERT INTO comments (product_id, customer_id, comment_text, comment_date, comment_parent_id, status)
            VALUES (?, ?, ?, NOW(), ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $productID,$u_id, $commentText, $parentID);
    $stmt->execute();

    // Redirect back to the product page or comment section
    header("Location: product.php?id=$productID");
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reply to Comment</title>
</head>
<body>
    <h1>Reply to Comment</h1>

    <form method="POST" action="reply.php?uid=2&pid=<?php echo $_GET['pid']; ?>&pr=<?php echo $_GET['pr']; ?>">
    
        <label for="comment">Reply:</label><br>
        <textarea name="comment" rows="4" cols="50"></textarea><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>