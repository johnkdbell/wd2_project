<?php
    session_start();
    if(isset($_SESSION['user']['userEmail']))
    {
        $userLogin = $_SESSION['user']['userLogin'];
    }
?>

<script src="js/navbar_scroll.js"></script>
<nav class="navbar navbar-expand-lg
            bg-dark fixed-top"
     id="mainNav">
    <div class="container" id="navbar">
        <?php if(isset($_SESSION['user']['userEmail'])): ?>

            <p>
                <a class="navbar-brand" href="index.php">            
                    <img src="images/Johnny.png" alt="user_avatar">                
                    <?= $userLogin ?>
                </a>
            </p>

        <?php else: ?>
            <p>
                <a class="navbar-brand" href="index.php">  
                    piffle
                </a>
            </p>
        <?php endif; ?>
            
        

    <div>
        
            <ul class="nav nav-pills flex-column flex-sm-row ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Page_2</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Page_3</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Page_4</a>
                </li>
            </ul>
            
        </div>
    
        <div>
            <ul class="nav nav-pills flex-column flex-sm-row ml-auto">
                <?php if(isset($_SESSION['user']['userEmail'])): ?>
                
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Account</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="logoff.php">Logout</a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Sign up</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>
        
</nav>