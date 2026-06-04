<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

require_once("../config/db.php");

$author_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT *
     FROM posts
     WHERE author_id = ?
     ORDER BY created_at DESC"
);

$stmt->bind_param("i", $author_id);
$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Posts</title>
</head>
<body>

<h2>My Posts</h2>

<a href="dashboard.php">Dashboard</a>

<hr>

<?php

if($result->num_rows > 0)
{
    while($row = $result->fetch_assoc())
    {
?>

        <div style="margin-bottom:30px;">

            <h3>
                <?php echo htmlspecialchars($row['title']); ?>
            </h3>

            <img
                src="../uploads/<?php echo $row['image_path']; ?>"
                width="250"
                alt="Post Image"
            >

            <p>
                <?php echo nl2br(htmlspecialchars($row['content'])); ?>
            </p>

            <small>
                <?php echo $row['created_at']; ?>
            </small>

            <br><br>

            <a href="edit_posts.php?id=<?php echo $row['id']; ?>">
                Edit
            </a>

            |

            <a href="../controllers/delete_post.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Are you sure you want to delete this post??')">
                Delete
            </a>
            
        </div>

        <hr>

<?php
    }
}
else
{
    echo "<p>No posts found.</p>";
}
?>

</body>
</html>