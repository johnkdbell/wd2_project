<?php
    require_once('connect.php');

    session_start();

    $query = "SELECT * FROM project_blog_posts";

    if(isset($_GET['tagName']) && isset($_SESSION['user']['userEmail']))
    {
        $tag = $_GET["tagName"];

        $query = "SELECT * FROM project_blog_posts WHERE tagName = '".$tag."'";

    }
    
    $statement = $db->prepare($query);
    $statement->execute();
    $fullblog = $statement->fetchAll();
    $project_blog_posts = array_reverse($fullblog);

    $i = 0;

    $postContent = $project_blog_posts[$i]['postContent'];
    $content = strip_tags($postContent);

    function cutContent($project_blog_posts, $i)
    {
        $contentCut = substr($project_blog_posts[$i]['postContent'], 0, 200);
        $contentRemaining = strrpos($contentCut, ' ');
        $content = $contentRemaining? substr($contentCut, 0, $contentRemaining) : substr($contentCut, 0);
        return strip_tags(html_entity_decode($content));
    }

    $tagQuery = "SELECT DISTINCT tagName FROM project_blog_posts ORDER BY tagName";
    $tagStatement = $db->prepare($tagQuery);
    $tagStatement->execute();
    $listedTags = $tagStatement->fetchAll();

    

?>

<!doctype html>
<html lang="en">
<head>
	<title>piffle: Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Spectral" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>

    <?php include("anatomy/navtop.php"); ?>
    
    <div class="container-fluid">

        <?php if(isset($_SESSION['user']['userEmail'])): ?>
            
            <div class="jumbotron">
                <h1 class="display-1">Salutations!</h1>
                <p>
                    This is a safe-space.
                </p>
                <hr>
                <p>
                    Please do not say bad things.
                </p>
                <p>
                <div class="buttons row">
                    <a class="btn btn-primary btn-lg" href="create.php" role="button">
                        Create New Post
                    </a>
                    <div class="container float-right d-flex align-self-center">                
                    <?php if(isset($_SESSION['user']['userEmail'])): ?>
                    <form action="index.php" method="get">
                    <input type="submit" name="orderBy" value="newest to oldest" />
                    <input type="submit" name="orderBy" value="oldest to newest" />
                    <input type="submit" name="orderBy" value="author" />
                    <input type="submit" name="orderBy" value="comments" />
                    </form>
                    <?php if(isset($_SESSION['user']['userEmail'])): ?>
                </div>
                <h6>Select posts by category:</h6>
                        <form action="tags.php" method="get">
                            <?php foreach($listedTags as $tag): ?>
                                <input type="submit" name="tagName" value=<?= $tag['tagName'] ?> />
                            <?php endforeach; ?>
                        </form>
                     <?php endif; ?>
            </div>            
        <?php endif; ?>
                </p>
            </div> 
        <?php else: ?>

        <?php endif; ?>      
        
        <div class="container-fluid">

            <div class="row">
                <?php include("anatomy/body.php"); ?>   
            </div>
        </div>               

    </div>

    <script 
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>
</html>