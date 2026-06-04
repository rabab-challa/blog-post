<?php

require_once("../config/db.php");

$sql = "
SELECT
    posts.*,
    users.username,
    categories.name AS category_name
FROM posts
JOIN users
    ON posts.author_id = users.id
JOIN categories
    ON posts.category_id = categories.id
ORDER BY posts.created_at DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>
</head>
<body>

<h2>All Blog Posts</h2>

<?php while($row = $result->fetch_assoc()) { ?>

    <hr>

    <h3>
        <?php echo htmlspecialchars($row['title']); ?>
    </h3>

    <p>
        <strong>Author:</strong>
        <?php echo htmlspecialchars($row['username']); ?>
    </p>

    <p>
        <strong>Category:</strong>
        <?php echo htmlspecialchars($row['category_name']); ?>
    </p>

    <img
        src="../uploads/<?php echo $row['image_path']; ?>"
        width="250"
    >

    <p>
        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
    </p>

    <small>
        <?php echo $row['created_at']; ?>
    </small>

<?php } ?>

</body>
</html>