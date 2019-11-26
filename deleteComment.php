<?php

    require('connect.php');

    $commentID = filter_input(INPUT_GET, 'commentID', FILTER_SANITIZE_NUMBER_INT);

    $postIDQuery = "SELECT postID FROM project_blog_comments WHERE commentID = " . $commentID;
    $statement1 = $db->prepare($postIDQuery); // Returns a PDOStatement object.
    $statement1->execute(); // The query is now executed.
    $postID = $statement1->fetch();


    $query = "DELETE FROM project_blog_comments WHERE commentID = :commentID LIMIT 1";
    $statement2 = $db->prepare($query);
    $statement2->bindValue('commentID', $commentID, PDO::PARAM_INT);
    $statement2->execute();
    
    header("Location: post.php?postID=" .$postID['postID']);

?>