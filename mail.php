<?php
include 'assets/includes/auth/oauth2.php';
include 'assets/includes/mail/func.php';
include 'assets/includes/layout/header.php';
echo '
    <!-- HEADER -->
    <header>
        <h2>Mail</h2>
    </header>
    ';
include 'assets/includes/layout/nav.php';
?>

<?php
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);   
    
    //GMAIL Output
    $gmail = new Google_Service_Gmail($client);
    echo json_encode(getMessage($gmail, 'me', '1637d5977acc28a5'));
    
} else {
    //Redirect if users permission denied
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>



<?php
include 'assets/includes/layout/footer.php';

?>
