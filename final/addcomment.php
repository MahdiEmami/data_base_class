<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the product_id from the query string parameter
    $product_id = $_GET['pr'];
    // Set the customer_id
    $customer_id = 2;
    // Get the comment text from the form
    $comment_text = $_POST['comment_text'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tvshop";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the comment into the database
    $sql = "INSERT INTO comments (product_id, customer_id, comment_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $product_id, $customer_id, $comment_text);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Comment inserted successfully
        // Redirect back to the product page after adding the comment
        header("Location: product.php?id=$product_id");
        exit;
    } else {
        // Error occurred while inserting the comment
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Comment</title>
</head>
<body>
    <h2>Add Comment</h2>
    <form method="POST" action="addcomment.php?pr=<?php echo $_GET['pr']; ?>">
        <label for="comment_text">Comment:</label><br>
        <textarea name="comment_text" id="comment_text" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
