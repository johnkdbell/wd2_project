<?php

    require_once('connect.php');
    session_start();

    $postID = $_SESSION['post']['postID'];

    $tagID = filter_input(INPUT_POST, 'tagID', FILTER_SANITIZE_SPECIAL_CHARS);
    $tagPostID = $postID;
    $tagName = filter_input(INPUT_POST, 'tagName', FILTER_SANITIZE_SPECIAL_CHARS);

    $queryTag = "INSERT INTO project_blog_tags (tagID, tagPostID, tagName) VALUES (:tagID, :tagPostID, :tagName)";
    $statement2 = $db->prepare($queryTag);
    $statement2->bindValue(':tagID', $tagID);
    $statement2->bindValue(':tagPostID', $tagPostID);
    $statement2->bindValue(':tagName', $tagName);

    $statement2->execute();


?>