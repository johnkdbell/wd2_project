<?php
    require('connect.php');
    session_start();
    
    if ($_POST && !empty($_POST['userEmail']) && !empty($_POST['userPassword']))
    {
        $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $query = "SELECT * FROM project_blog_users WHERE userEmail = '$email'";
        $statement = $db->prepare($query); // Returns a PDOStatement object.
        $statement->execute(); // The query is now executed.
        $user = $statement->fetch();
        $hashedpassword = $user['userPassword'];
        

        if($statement->execute())
        {
            $valid = password_verify($password, $hashedpassword);
            if ($valid)
            {
                //header("Location: welcome.php");
                header("Location: index.php");
                $_SESSION['user'] = $user;
                
            }
            else
            {

            }

        }

    }
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
    
    <div class="container">

        <div class="main-content">
            <form method="post" action="login.php">
                <label for="userEmail">Email Address: </label>
                <input type="email" id="userEmail" name="userEmail">
                <label for="userPassword">Password: </label>
                <input type="password" id="userPassword" name="userPassword">
                <input type="submit">
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