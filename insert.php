<?php

    require_once('connect.php');
    session_start();
    header("Location: index.php");

    $postID = filter_input(INPUT_POST, 'postID', FILTER_SANITIZE_SPECIAL_CHARS);
    $postHeading = filter_input(INPUT_POST, 'postHeading', FILTER_SANITIZE_SPECIAL_CHARS);
    $postDate = date('Y-m-d h:i:sa');
    $postContent = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_SPECIAL_CHARS);

    $query = "INSERT INTO project_blog_posts (postID, userID, postHeading, postDate, postContent) VALUES (:postID, :userID, :postHeading, :postDate, :postContent)";
    $statement = $db->prepare($query);
    $statement->bindValue(':postID', $postID);
    $statement->bindValue('userID', $_SESSION['user']['userID']);
    $statement->bindValue(':postHeading', $postHeading);
    $statement->bindValue(':postDate', $postDate);
    $statement->bindValue(':postContent', $postContent);

    $statement->execute();
    exit();

?>