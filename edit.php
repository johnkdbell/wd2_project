<?php
    require('connect.php'); 
    //require('authenticate.php');

    $query = "SELECT * FROM project_blog_posts WHERE postID = :postID LIMIT 1";
    $statement = $db->prepare($query);
    $postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
    $statement->bindValue('postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blog - <?= $post['postHeading']?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Spectral" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css"> 
</head>    
<body>           

    <?php include("anatomy/navtop.php"); ?>
    
    <div class="container">
        
        <?php if (isset($_SESSION['user']['userEmail'])): ?>
        
            <form method="post" action="update.php">
                <input type="hidden" name="postID" value="<?= $postID ?>">
                <input type="hidden" name="postDate"> 
                <input type="text" name="postHeading" value="<?= $post['postHeading'] ?>">
                <br />
                <textarea rows="4" cols="50" name="postContent"><?= $post['postContent'] ?></textarea>
                <input type="submit" value="Edit">
            </form> 
            
            <form method="post" action="delete.php">
                <input type="hidden" name="postID" value="<?= $postID ?>">
                <input type="submit" value="Delete">
            </form>
            
            <form method="post" action="index.php">
                <input type="submit" value="Return">
            </form>
        
        <?php else: ?>
            <?php header("Location: index.php"); ?>
        
        <?php endif; ?>
    
    </div>
</body>
</html>

