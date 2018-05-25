<?php
    session_start();
    require_once 'assets/lib/google_API_v2.0/autoload.php';

    $Google_Client = new Google_Client();
    $Google_Client->setApplicationName('Bridge v1.1');
    $Google_Client->setAuthConfig('assets/lib/google_API_v2.0/client_secrets.json');
    $Google_Client->addScope('https://mail.google.com/');
    $Google_Client->addScope('https://www.googleapis.com/auth/drive');
    $Google_Client->addScope('https://www.googleapis.com/auth/calendar');
    $Google_Client->addScope(['profile']);
    $Google_Client->addScope(['email']);
    $Google_Client->setAccessType('offline');
    $Google_Client->setIncludeGrantedScopes(true);
    $Google_Client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/googleCallback.php');
?>