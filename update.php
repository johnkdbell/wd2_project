<?php

    require_once('connect.php');
    header("Location: index.php");

    $postID = filter_input(INPUT_POST, 'postID', FILTER_SANITIZE_NUMBER_INT);
    $postHeading = filter_input(INPUT_POST, 'postHeading', FILTER_SANITIZE_SPECIAL_CHARS);
    $postDate = date('Y-m-d h:i:sa');
    $postContent = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_SPECIAL_CHARS);

    $query = "UPDATE project_blog_posts SET postID = :postID, postDate = :postDate, postHeading = :postHeading, postContent = :postContent WHERE postID = :postID";
    $statement = $db->prepare($query);
    $statement->bindValue(':postID', $postID);
    $statement->bindValue(':postHeading', $postHeading);
    $statement->bindValue(':postDate', $postDate);
    $statement->bindValue(':postContent', $postContent);

    $statement->execute();
    $post = $statement->fetch();

?>
