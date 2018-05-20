<?php
require_once __DIR__.'/assets/php-oauth2/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('assets/php-oauth2/client_secrets.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
$client->addScope('https://mail.google.com/');
$client->addScope('https://www.googleapis.com/auth/drive');
$client->addScope('https://www.googleapis.com/auth/calendar');

if (! isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>