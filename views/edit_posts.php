<?php

    session_start();
    require_once("../config/db.php");

    $post_id = $_GET['id'];
    $author_id = $_SESSION['user_id'];

    $stmt = $conn->prepare(
        "SELECT *
        FROM posts
        WHERE id = ?
        AND author_id = ?"
    );

    $stmt->bind_param(
        "ii",
        $post_id,
        $author_id
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 0)
    {
        die("Post not found or access denied.");
    }

    $post = $result->fetch_assoc();


?>  

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<form action="../controllers/update_post.php"
      method="POST">

    <input
        type="hidden"
        name="post_id"
        value="<?php echo $post['id']; ?>"
    >

    <label>Title</label>
    <br>

    <input
        type="text"
        name="title"
        value="<?php echo htmlspecialchars($post['title']); ?>"
        required
    >

    <br><br>

    <label>Content</label>
    <br>

    <textarea
        name="content"
        rows="6"
        cols="50"
        required><?php echo htmlspecialchars($post['content']); ?></textarea>

    <br><br>

    <label>Category</label>
    <br>

    <select name="category">

        <option value="1"
        <?php if($post['category_id']==1) echo "selected"; ?>>
            Entertainment
        </option>

        <option value="2"
        <?php if($post['category_id']==2) echo "selected"; ?>>
            Educational
        </option>

    </select>

    <br><br>

    <button type="submit" name="update_post">
        Update Post
    </button>

</form>

</body>
</html>