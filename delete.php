<?php

    require('connect.php');    
    header("Location: index.php");

    $query = "DELETE FROM project_blog_posts WHERE postID = :postID LIMIT 1";
    $statement = $db->prepare($query);
    $postID = filter_input(INPUT_POST, 'postID', FILTER_SANITIZE_NUMBER_INT);
    $statement->bindValue('postID', $postID, PDO::PARAM_INT);
    $statement->execute();

?>