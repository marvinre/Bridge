<?php
    require_once 'assets/basic/init.php';

    if(isset($_SESSION['access_token'])){
        $Google_Client->setAccessToken($_SESSION['access_token']);
    } else if (isset($_GET['code'])){
        $token = $Google_Client->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
        $_SESSION['refresh_token'] = $token['refresh_token'];
        $_SESSION['expires_in'] = $token['expires_in'];
        
        //REFRSH_TOKEN in Datenbank speichern!!!!!
        
    } else {
        header('Location: login.php');
        exit();
    }

    $Oauth2_Service = new Google_Service_Oauth2($Google_Client);

    //SESSION User data
    $_SESSION['email']              = $Oauth2_Service->userinfo->get()->email;
    $_SESSION['vorname']            = $Oauth2_Service->userinfo->get()->givenName;
    $_SESSION['nachname']           = $Oauth2_Service->userinfo->get()->familyName;
    $_SESSION['profilbild']         = $Oauth2_Service->userinfo->get()->picture;

    header('Location: index.php');
    exit();
?>