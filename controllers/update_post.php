<?php

session_start();
require_once("../config/db.php");

if(isset($_POST['update_post']))
{
    $post_id = $_POST['post_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category'];

    $author_id = $_SESSION['user_id'];

    $stmt = $conn->prepare(
        "UPDATE posts
         SET title = ?,
             content = ?,
             category_id = ?
         WHERE id = ?
         AND author_id = ?"
    );

    $stmt->bind_param(
        "ssiii",
        $title,
        $content,
        $category_id,
        $post_id,
        $author_id
    );


    // Get old category
    $old_stmt = $conn->prepare(
        "SELECT category_id
        FROM posts
        WHERE id = ?
        AND author_id = ?"
    );

    $old_stmt->bind_param(
        "ii",
        $post_id,
        $author_id
    );

    $old_stmt->execute();

    $old_result = $old_stmt->get_result();
    $old_post = $old_result->fetch_assoc();

    $old_category_id = $old_post['category_id'];

    $old_points_stmt = $conn->prepare(
        "SELECT points
        FROM categories
        WHERE id = ?"
    );

    $old_points_stmt->bind_param(
        "i",
        $old_category_id
    );

    $old_points_stmt->execute();

    $old_points =
        $old_points_stmt
        ->get_result()
        ->fetch_assoc()['points'];

    $new_points_stmt = $conn->prepare(
        "SELECT points
        FROM categories
        WHERE id = ?"
    );

    $new_points_stmt->bind_param(
        "i",
        $category_id
    );

    $new_points_stmt->execute();

    $new_points =
        $new_points_stmt
        ->get_result()
        ->fetch_assoc()['points'];
    

    $difference = $new_points - $old_points;



    $user_stmt = $conn->prepare(
        "UPDATE users
        SET points = points + ?
        WHERE id = ?"
    );

    $user_stmt->bind_param(
        "ii",
        $difference,
        $author_id
    );

    // $user_stmt->execute();




    if($stmt->execute())
    {
        header("Location: ../views/my_post.php");
        exit();
    }
    else
    {
        echo $stmt->error;
    }
}
?>