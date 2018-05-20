<?php
include 'assets/includes/auth/oauth2.php';
include 'assets/includes/layout/header.php';
echo '
    <!-- HEADER -->
    <header>
        <h2>Home</h2>
    </header>
    ';
include 'assets/includes/layout/nav.php';
?>


<?php
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    
    //DRIVE Output
    $drive = new Google_Service_Drive($client);
    $files = $drive->files->listFiles(array())->getFiles();
    echo json_encode($files);
    
    

    
} else {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

?>







<?php
include 'assets/includes/layout/footer.php';

?>