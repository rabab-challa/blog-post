<?php

session_start();
require_once("../config/db.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Blogs</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .post{
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }

        img{
            max-width: 250px;
        }
    </style>

</head>
<body>

<h2>🔍 Search Blogs</h2>

<form method="GET">

    <input
        type="text"
        name="search"
        placeholder="Search by title or content..."
        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
        required
    >

    <button type="submit">
        Search
    </button>

</form>

<br>

<a href="dashboard.php">
    Back to Dashboard
</a>

<hr>

<?php

if(isset($_GET['search']))
{
    $search = trim($_GET['search']);

    $keyword = "%" . $search . "%";

    $stmt = $conn->prepare(
        "SELECT
            posts.*,
            users.username,
            categories.name AS category_name
         FROM posts
         JOIN users
            ON posts.author_id = users.id
         JOIN categories
            ON posts.category_id = categories.id
         WHERE posts.title LIKE ?
         OR posts.content LIKE ?
         ORDER BY posts.created_at DESC"
    );

    $stmt->bind_param(
        "ss",
        $keyword,
        $keyword
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
?>

<div class="post">

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
        alt="Post Image"
    >

    <p>
        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
    </p>

    <small>
        <?php echo $row['created_at']; ?>
    </small>

</div>

<?php
        }
    }
    else
    {
        echo "<h3>No posts found.</h3>";
    }
}
?>

</body>
</html>