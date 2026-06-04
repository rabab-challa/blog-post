<?php

session_start();
require_once("../config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: ../views/login.php");
    exit();
}

if(isset($_GET['id']))
{
    $post_id = $_GET['id'];
    $author_id = $_SESSION['user_id'];

    // Get category of the post
    $post_stmt = $conn->prepare(
        "SELECT category_id
         FROM posts
         WHERE id = ?
         AND author_id = ?"
    );

    $post_stmt->bind_param(
        "ii",
        $post_id,
        $author_id
    );

    $post_stmt->execute();

    $result = $post_stmt->get_result();

    if($result->num_rows > 0)
    {
        $post = $result->fetch_assoc();

        $category_id = $post['category_id'];

        // Get points for that category
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

        $cat_result = $cat_stmt->get_result();
        $category = $cat_result->fetch_assoc();

        $points = $category['points'];

        // Reduce user points
        $update_stmt = $conn->prepare(
            "UPDATE users
             SET points = points - ?
             WHERE id = ?"
        );

        $update_stmt->bind_param(
            "ii",
            $points,
            $author_id
        );

        $update_stmt->execute();

        // Delete post
        $delete_stmt = $conn->prepare(
            "DELETE FROM posts
             WHERE id = ?
             AND author_id = ?"
        );

        $delete_stmt->bind_param(
            "ii",
            $post_id,
            $author_id
        );

        $delete_stmt->execute();
    }

    header("Location: ../views/my_posts.php");
    exit();
}