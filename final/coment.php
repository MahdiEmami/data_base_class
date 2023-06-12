<!DOCTYPE html>
<html>
<head>
    <title>Comments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .comment {
            margin-bottom: 20px;
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
            margin-left: 30px;
            border-left: 1px solid #ccc;
            padding-left: 10px;
        }
    </style>
</head>
<body>
    <h1>Comments</h1>

    <?php
    // Database connection settings
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "tvshop";

    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);

    // Function to recursively display comments
    function displayComments($comments, $parent_id = 0, $level = 0) {
        foreach ($comments as $comment) {
            if ($comment['comment_parent_id'] == $parent_id) {
                $date = date("F j, Y", strtotime($comment['comment_date']));
                $text = htmlspecialchars($comment['comment_text']);

                echo '<div class="comment" style="margin-left: ' . $level * 30 . 'px">';
                echo '<div class="date">' . $date . '</div>';
                echo '<div class="text">' . $text . '</div>';
                echo '</div>';

                displayComments($comments, $comment['comment_id'], $level + 1);
            }
        }
    }

    // Query to retrieve comments
    $query = "SELECT * FROM comments WHERE status = 1 ORDER BY comment_date DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display comments
    displayComments($comments);

    ?>

</body>
</html>
