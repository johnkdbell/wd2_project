<?php
    require('connect.php');

    if (session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    $query = "SELECT * FROM project_blog_posts WHERE postID = :postID LIMIT 1";
    $statement = $db->prepare($query);
    $postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
    $statement->bindValue('postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch();

    if(isset($_POST['captcha_challenge']) && $_POST['captcha_challenge'] == $_SESSION['captcha_text'])
    {
        if (!empty($_POST['commentContent']))
        {
            require_once('connect.php');
            session_start();
            header("Location: post.php?postID=".$postID);

            $postID = $post['postID'];
            $commentAuthor = $_SESSION['user']['userID'];
            $commentDate = date('Y-m-d h:i:sa');
            $commentContent = filter_input(INPUT_POST, 'commentContent', FILTER_SANITIZE_SPECIAL_CHARS);

            $query = "INSERT INTO project_blog_comments (postID, commentAuthor, commentDate, commentContent) VALUES (:postID, :commentAuthor, :commentDate, :commentContent)";
            $commentstatement = $db->prepare($query);
            $commentstatement->bindValue(':postID', $postID, PDO::PARAM_INT);
            $commentstatement->bindValue(':commentAuthor', $commentAuthor);
            $commentstatement->bindValue(':commentDate', $commentDate);
            $commentstatement->bindValue(':commentContent', $commentContent);

            $commentstatement->execute();

            $setCommentCount = "UPDATE project_blog_posts SET postCommentCount = postCommentCount + 1 WHERE postID = " . $post['postID'];
            $statement4 = $db->prepare($setCommentCount);
            $statement4->execute();


        }
    }
    else
    {
        $commentContent = filter_input(INPUT_POST, 'commentContent', FILTER_SANITIZE_SPECIAL_CHARS);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blog — <?= $post['postHeading'] ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Spectral" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css"> 
    <script src="https://kit.fontawesome.com/4263976262.js" crossorigin="anonymous"></script>
</head>
<body>
                        
<?php include("anatomy/navtop.php"); ?>
    <div class="container">
        
        <h2 class="post-preview"><?= $post['postHeading'] ?></h2>
        <br>
        <p class="post-preview"><?= html_entity_decode($post['postContent']) ?></p>
        <br>
        <br>
        
        <p class="post-preview"><?= $post['postDate'] ?></p>
        <br>
        <br>
        
        <form method="post" action="post.php?postID=<?=$postID ?>">
    <div class="row">
        Commenting as:
    </div>
    <div class="row form-element">
        <?php
            $userquery2 = "SELECT userLogin FROM project_blog_users WHERE userID = ".$_SESSION['user']['userID'];
            $stmt3 = $db->prepare($userquery2); // Returns a PDOStatement object.
            $stmt3->execute(); // The query is now executed.
            $userdisplayname = $stmt3->fetch();
        ?>
        <h6><?= $userdisplayname['userLogin'] ?></h6>
    </div>
    <div class="row">
        <label for="commentContent"><h3>Comment: </h3></label>
    </div>
    <div class="row form-element">
        <textarea class="form-element" id="commentContent" name="commentContent" row="100" cols="200"><?= $commentContent ?></textarea>
    </div>

    <input type="hidden" id="commentAuthor" name="commentAuthor" value="<?= $_SESSION['user']['userID'] ?>">
    <input type="hidden" id="postID" name="postID">
    <input type="hidden" id="commentDate" name="commentDate">

    <div class="row form-element">
        <label for="captcha">Please Enter the Captcha Text</label>
        <img src="captcha.php" alt="CAPTCHA" class="captcha-image"><i class="fas fa-redo refresh-captcha"></i>
        <br>
        <input type="text" id="captcha" name="captcha_challenge" pattern="[A-Z]{6}">
    </div><br>
    
    <div class="row form-element">
        <input type="submit" value="Comment">
    </div>
    </form>

    <br><br>

    <p>Comments</p>
        <?php
            $commentQuery = "SELECT * FROM project_blog_comments
                             LEFT JOIN project_blog_posts
                             ON project_blog_comments.postID = project_blog_posts.postID
                             WHERE project_blog_comments.postID = " . $post['postID'];
            $statement2 = $db->prepare($commentQuery);
            $statement2->execute();
            $comments = $statement2->fetchAll();
        ?>

        <?php foreach($comments as $comment): ?>

        <?php
            $userLoginQuery = "SELECT userLogin FROM project_blog_users WHERE userID = " . $comment['commentAuthor'];
            $statement3 = $db->prepare($userLoginQuery);
            $statement3->execute();
            $userLogin = $statement3->fetch();
        ?>

        <h3><?= $userLogin['userLogin'] ?></h3>
        <p><?= $comment['commentContent'] ?></p>
        <p><?= $comment['commentDate'] ?></p>
        <br>
        
        <?php endforeach; ?>

        <br>
        <br>        
        <form method="post" action="index.php">
            <input type="submit" value="Return">
        </form>

    </div>

    <script>
        var refreshButton = document.querySelector(".refresh-captcha");
        refreshButton.onclick = function() {
        document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
        }
    </script>

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

