<?php
    session_start();
    require_once("../config/db.php");
    if(!isset($_SESSION['user_id']))
    {
        header("Location: login.php");
        exit();
    }
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare(
        "SELECT username, points
        FROM users
        WHERE id = ?"
    );

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    //total posts
    $total_stmt = $conn->prepare(
        "SELECT COUNT(*) AS total_posts
        FROM posts
        WHERE author_id = ?"
    );

    $total_stmt->bind_param("i", $user_id);
    $total_stmt->execute();

    $total_posts = $total_stmt
        ->get_result()
        ->fetch_assoc()['total_posts'];

    //educational points
    $edu_stmt = $conn->prepare(
        "SELECT COUNT(*) AS educational_posts
        FROM posts
        WHERE author_id = ?
        AND category_id = 2"
    );

    $edu_stmt->bind_param("i", $user_id);
    $edu_stmt->execute();

    $educational_posts = $edu_stmt
        ->get_result()
        ->fetch_assoc()['educational_posts'];

    //entertainment points
    $ent_stmt = $conn->prepare(
        "SELECT COUNT(*) AS entertainment_posts
        FROM posts
        WHERE author_id = ?
        AND category_id = 1"
    );

    $ent_stmt->bind_param("i", $user_id);
    $ent_stmt->execute();

    $entertainment_posts = $ent_stmt
        ->get_result()
        ->fetch_assoc()['entertainment_posts'];

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>
    Welcome <?php echo htmlspecialchars($user['username']); ?>
</h2>

<h3>
    Current Points:
    <?php echo $user['points']; ?>
</h3>

<hr>

<h3>Statistics</h3>

<p>
    Total Posts:
    <?php echo $total_posts; ?>
</p>

<p>
    Educational Posts:
    <?php echo $educational_posts; ?>
</p>

<p>
    Entertainment Posts:
    <?php echo $entertainment_posts; ?>
</p>

<hr>

<a href="create_post.php">Create Post</a>
<br><br>

<a href="view_post.php">View All Posts</a>
<br><br>

<a href="my_post.php">My Posts</a>
<br><br>

<a href="search_posts.php">
    Search Blogs
</a>

<br><br>

<a href="../controllers/logout.php">Logout</a>
</body>
</html>