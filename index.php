<?php
    require_once 'assets/basic/init.php';

    if(!isset($_SESSION['access_token'])){
        header('Location: login.php');
        exit();
    }
?>


<html>
    <head>
        <title>Logged In - Home</title>
    </head>
    <body>
        <form action="logout.php">
            <input type="submit" name="logout" value="Logout">
        </form>
        <?php 
            echo $_SESSION['vorname'].'<br>';
            echo $_SESSION['nachname'].'<br>';
            echo $_SESSION['email'].'<br>';
            echo '<img src="'.$_SESSION['profilbild'].'" style="width: 200px;">';
        
            //Dient dazu, den oben inkludierten Google Client {{$Google_Client}} den access_token zuzuweisen
            if ($Google_Client->isAccessTokenExpired()) {
                $Google_Client->refreshToken($_SESSION['refresh_token']);
            }
        ?>
        <!-- NAVIGATION -->
        <nav>
            <h2>Navigation</h2>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="mail.php">Mail</a></li>
                <li><a href="#">Kalender</a></li>
                <li><a href="#">To Do</a></li>
                <li><a href="#">Chat</a></li>
            </ul>
        </nav>
    </body>
</html>