<?php
    require 'assets/basic/init.php';

    if(isset($_SESSION['access_token'])){
        header('Location: index.php');
        exit();
    }

    $loginURL = $Google_Client->createAuthUrl();
?>

<html>
    <head>
    </head>
    <body>
        <form>
            <input type="button" onclick="window.location = '<?php echo $loginURL; ?>';" value="Sign In /w Google">
        </form>
    </body>
</html>