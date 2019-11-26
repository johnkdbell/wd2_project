<?php
    require('connect.php');
    //require('authenticate.php');

    $query = "SELECT * FROM project_blog_posts WHERE postID = :postID LIMIT 1";
    $statement = $db->prepare($query);
    $postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
    $statement->bindValue('postID', $postID, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch();

    $queryTag = "SELECT DISTINCT tagName FROM project_blog_tags WHERE tagPostID = " . $postID;
    $statement2 = $db->prepare($queryTag);
    $statement2->execute();
    $tags = $statement2->fetchAll();


?>

<!doctype html>
<html lang="en">
<head>
    <title>New Post <?= $post['postHeading']?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Spectral" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" type="text/css">
    
    <script src="js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea',
            plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
            ],
            toolbar: 'insertfile undo redo | fontselect fontsizeselect formatselect | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
            menubar: false
        });
    </script>
</head>
<body>                     
    <?php include("anatomy/navtop.php"); ?>
    <div class="container">
    
    <div class="container">
    <form action="insert.php" method="post">
        <div class="input">
            <input type="hidden" name="postID">
            <input type="hidden" name="postDate"> 
            <input type="text" name="postHeading" placeholder="Title">
            <br>
            <textarea rows="4" cols="50" name="postContent" placeholder="Write your post here..."></textarea>
            <br>
            <div class="input">            
            <input type="hidden" id="tagID" name="tagID">
            <input type="hidden" id="tagPostID" name="tagPostID" value="<?= $postID ?>">
                <select name="tagName">
                    <option>Existing tags:</option>
                    <?php foreach($tags as $tag): ?>
                        <option><?= $tag['tagName'] ?></option>
                    <?php endforeach; ?>
                </select>

                Add a tag:
                <input type="text" id="tagName" name="tagName">
            </div>
            <br>

            <input type="submit" value="Post">
        </div>
    </form>
    <form method="post" action="index.php">
            <input type="submit" value="Return">
    </form>
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