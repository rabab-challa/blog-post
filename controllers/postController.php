<?php
session_start();
require_once("../config/db.php");

if(isset($_POST['create_post'])){
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = trim($_POST['category']);

    $author_id = $_SESSION['user_id'];

    //image data
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    $upload_path = "../uploads/" . $image_name;

    move_uploaded_file($image_tmp, $upload_path);

//     echo "Category ID = " . $category_id;
// echo "<br>";
// echo "Author ID = " . $author_id;
// exit();



    //insert post
    $stmt = $conn->prepare(
        "INSERT INTO posts(title, content, image_path, category_id, author_id) VALUES(?,?,?,?,?)"
    );
    $stmt->bind_param("sssii", $title, $content,$image_name, $category_id, $author_id);
     if($stmt->execute())
    {
        // Get category points
        $points = 0;

        $cat_stmt = $conn->prepare(
            "SELECT points
             FROM categories
             WHERE id = ?"
        );

        $cat_stmt->bind_param(
            "i",
            $category_id
        );

        $cat_stmt->execute();

        $cat_stmt->bind_result($points);

        if($cat_stmt->fetch())
        {
            $cat_stmt->close();

            // Update user points
            $update_stmt = $conn->prepare(
                "UPDATE users
                 SET points = points + ?
                 WHERE id = ?"
            );

            $update_stmt->bind_param(
                "ii",
                $points,
                $author_id
            );

            $update_stmt->execute();

            $update_stmt->close();
        }

        // Redirect to dashboard
        header("Location: ../views/dashboard.php");
        exit();
    }
    else
    {
        echo $stmt->error;
    }
}

?>