<?php
    require('connect.php');
    
    if ($_POST && !empty($_POST['userEmail']) && !empty($_POST['userPassword']) && ($_POST['userPassword'] == $_POST['userPasswordValid']))
    {
        $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $loginName = filter_input(INPUT_POST, 'userLogin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $hashedpassword = password_hash( $password , PASSWORD_DEFAULT );
        
        $query = "INSERT INTO project_blog_users (userEmail, userPassword, userLogin) VALUES (:userEmail, :userPassword, :userLogin)";
        $statement = $db->prepare($query);
        
        $statement->bindValue(':userEmail', $email);
        $statement->bindValue(':userPassword', $hashedpassword);
        $statement->bindValue(':userLogin', $loginName);
        
        if($statement->execute())
        {
            header("Location: login.php");
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
        <form method="post" action="register.php">
                <label for="userLogin">Username: </label>
                <input type="text" id="userLogin" name="userLogin">
                <br><br>
                <label for="userEmail">Email Address: </label>
                <input type="email" id="userEmail" name="userEmail">
                <br><br>
                <label for="userPassword">Password: </label>
                <input type="password" id="userPassword" name="userPassword">
                <br><br>
                <label for="userPassword">Confirm Password: </label>
                <input type="password" id="userPassword" name="userPasswordValid">
                <br><br>
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