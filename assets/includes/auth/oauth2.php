<?php
require_once 'assets/php-oauth2/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setApplicationName('Bridge.io');
$client->setAuthConfig('assets/php-oauth2/client_secrets.json');
$client->addScope('https://mail.google.com/');
$client->addScope('https://www.googleapis.com/auth/drive');
$client->addScope('https://www.googleapis.com/auth/calendar');
$client->setAccessType('offline');

?>