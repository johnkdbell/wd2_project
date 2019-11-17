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

    <div class="main-content">
    <form method="post" action="register.php">
            <label for="userLogin">Username: </label>
            <input type="text" id="userLogin" name="userLogin">
            <label for="userEmail">Email Address: </label>
            <input type="email" id="userEmail" name="userEmail">
            <label for="userPassword">Password: </label>
            <input type="password" id="userPassword" name="userPassword">
            <label for="userPassword">Confirm Password: </label>
            <input type="password" id="userPassword" name="userPasswordValid">
            <input type="submit">
        </form>
    </div>
