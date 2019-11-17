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

    <div class="main-content">
        <form method="post" action="login.php">
            <label for="userEmail">Email Address: </label>
            <input type="email" id="userEmail" name="userEmail">
            <label for="userPassword">Password: </label>
            <input type="password" id="userPassword" name="userPassword">
            <input type="submit">
        </form>
    </div>
