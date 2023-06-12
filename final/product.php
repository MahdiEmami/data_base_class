<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
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
        .comment {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .comment .author {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .comment .date {
            color: #888;
            font-size: 12px;
        }
        .comment .text {
            margin-top: 5px;
        }
        .child-comment {
            margin-left: 20px;
            border-left: 1px solid #ccc;
            padding-left: 10px;
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

    // Get product_id from the query string
    $product_id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($product_id) {
        // Retrieve product details
        $productQuery = "SELECT * FROM products WHERE product_id = :product_id AND status = 1";
        $productStmt = $pdo->prepare($productQuery);
        $productStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $productStmt->execute();
        $product = $productStmt->fetch(PDO::FETCH_ASSOC);

        // Retrieve comments for the product
        $commentQuery = "SELECT * FROM comments WHERE product_id = :product_id AND status = 1 ORDER BY comment_date DESC";
        $commentStmt = $pdo->prepare($commentQuery);
        $commentStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $commentStmt->execute();
        $comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($product) {
            $name = htmlspecialchars($product['product_name']);
            $description = htmlspecialchars($product['description']);

            echo '<h1>Product Details</h1>';
            echo '<div class="product">';
            echo '<div class="name">' . $name . '</div>';
            echo '<div class="description">' . $description . '</div>';
            echo '</div>';

            if ($comments) {
                echo '<h2>Comments</h2>';
                foreach ($comments as $comment) {
                    if (!$comment['comment_parent_id']) {
                        $date = date("F j, Y", strtotime($comment['comment_date']));
                        $text = htmlspecialchars($comment['comment_text']);
                        $commentId = $comment['comment_id'];
                        echo '<div class="comment">';
                        echo '<div class="date">' . $date . '</div>';
                        echo '<div class="text">' . $text . '</div>';
                        echo '<a href="reply.php?pid=' . $commentId . '&pr=' . $_GET["id"] . '">' . 'reply' . '</a>';


                        echo '<div class="child-comments">';
                        foreach ($comments as $childComment) {
                            if ($childComment['comment_parent_id'] == $commentId) {
                                $childDate = date("F j, Y", strtotime($childComment['comment_date']));
                                $childText = htmlspecialchars($childComment['comment_text']);

                                echo '<div class="child-comment">';
                                echo '<div class="date">' . $childDate . '</div>';
                                echo '<div class="text">' . $childText . '</div>';
                                echo '<a href="reply.php?pid=' . $childComment['comment_id'] . '&pr=' . $_GET["id"] . '">' . 'reply' . '</a>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';

                        echo '</div>';
                    }
                }
            } else {
                echo '<a href="addcomment.php?pr='.$_GET['id'].'">add a comment</a>';
            }
        } else {
            echo '<p>Invalid product ID.</p>';
        }
    } else {
        echo '<p>No product ID specified.</p>';
    }
    ?>

</body>
</html>
