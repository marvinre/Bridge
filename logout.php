<?php
    require_once 'assets/basic/init.php';

    unset($_SESSION['access_token']);
    $Google_Client->revokeToken();
    session_destroy();
    header('Location: login.php');
    exit();
?>