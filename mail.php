<?php
    require_once 'assets/basic/init.php';

    if(!isset($_SESSION['access_token'])){
        header('Location: login.php');
        exit();
    }

    ini_set("display_errors", 1);
    ini_set("track_errors", 1);
    ini_set("html_errors", 1);
    error_reporting(E_ALL);
?>


<html>
    <head>
        <title>Logged In - Mail</title>
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
        
            //Erzeugen der Google Services
            $gmail_service = new Google_Service_Gmail($Google_Client);
        
        
            function getMessage($service, $messageId){
                try {
                    $message = $service->users_messages->get('me', $messageId);
                    print 'Message ID: ' . $message->getId() . '<br>';
                    
                    $message_id = $message->getId();
                    $optParamsGet2['format'] = 'full';
                    $single_message = $service->users_messages->get('me', $message_id, $optParamsGet2);
                    $payload = $single_message->getPayload();

                    // With no attachment, the payload might be directly in the body, encoded.
                    $body = $payload->getBody();
                    $FOUND_BODY = decodeBody($body['data']);

                    // If we didn't find a body, let's look for the parts
                    if(!$FOUND_BODY) {
                        $parts = $payload->getParts();
                        foreach ($parts  as $part) {
                            if($part['body'] && $part['mimeType'] == 'text/html') {
                                $FOUND_BODY = decodeBody($part['body']->data);
                                break;
                            }
                        }
                    } if(!$FOUND_BODY) {
                        foreach ($parts  as $part) {
                            // Last try: if we didn't find the body in the first parts, 
                            // let's loop into the parts of the parts (as @Tholle suggested).
                            if($part['parts'] && !$FOUND_BODY) {
                                foreach ($part['parts'] as $p) {
                                    // replace 'text/html' by 'text/plain' if you prefer
                                    if($p['mimeType'] === 'text/html' && $p['body']) {
                                        $FOUND_BODY = decodeBody($p['body']->data);
                                        break;
                                    }
                                }
                            }
                            if($FOUND_BODY) {
                                break;
                            }
                        }
                    }
                    
                    print $FOUND_BODY;
                    
                    return $message;
                } catch (Exception $e) {
                    print 'An error occurred: ' . $e->getMessage();
                }
            }
        
            function getMsg($service, $userId){
                try {
                    $messages = $service->users_messages;
                    echo '<pre>';
                    print_r($messages);
                    echo '</pre>';
                    return $messages;
                } catch(Exception $e){
                    print $e->getMessage();
                }
            }
        
        
            function decodeBody($body) {
                $rawData = $body;
                $sanitizedData = strtr($rawData,'-_', '+/');
                $decodedMessage = base64_decode($sanitizedData);
                if(!$decodedMessage){
                    $decodedMessage = FALSE;
                }
                return $decodedMessage;
            }

            function fetchMails($gmail) {
                $opt_param = array('labelIds' => array('UNREAD', 'INBOX'));
                try{
                    $list = $gmail->users_messages->listUsersMessages('me', $opt_param);
                    while ($list->getMessages() != null) {

                        foreach ($list->getMessages() as $mlist) {

                            $message_id = $mlist->id;
                            $optParamsGet2['format'] = 'full';
                            $single_message = $gmail->users_messages->get('me', $message_id, $optParamsGet2);
                            $payload = $single_message->getPayload();

                            // With no attachment, the payload might be directly in the body, encoded.
                            $body = $payload->getBody();
                            $FOUND_BODY = decodeBody($body['data']);

                            // If we didn't find a body, let's look for the parts
                            if(!$FOUND_BODY) {
                                $parts = $payload->getParts();
                                foreach ($parts  as $part) {
                                    if($part['body'] && $part['mimeType'] == 'text/html') {
                                        $FOUND_BODY = decodeBody($part['body']->data);
                                        break;
                                    }
                                }
                            } if(!$FOUND_BODY) {
                                foreach ($parts  as $part) {
                                    // Last try: if we didn't find the body in the first parts, 
                                    // let's loop into the parts of the parts (as @Tholle suggested).
                                    if($part['parts'] && !$FOUND_BODY) {
                                        foreach ($part['parts'] as $p) {
                                            // replace 'text/html' by 'text/plain' if you prefer
                                            if($p['mimeType'] === 'text/html' && $p['body']) {
                                                $FOUND_BODY = decodeBody($p['body']->data);
                                                break;
                                            }
                                        }
                                    }
                                    if($FOUND_BODY) {
                                        break;
                                    }
                                }
                            }
                            // Finally, print the message ID and the body
                            print_r($message_id . " <br> <br> <br> *-*-*- " . $FOUND_BODY);
                        }

                        if ($list->getNextPageToken() != null) {
                            $pageToken = $list->getNextPageToken();
                            $list = $gmail->users_messages->listUsersMessages('me', array('pageToken' => $pageToken));
                        } else {
                            break;
                        }
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

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
        <section>
            <table>
                <tr>
                    <th>Betreff</th>
                    <th>Preview</th>
                    <th>Inhalt</th>
                </tr>
                <!-- Foreach ... -->
                <tr>
                    <td>Test</td>
                    <td>Test2</td>
                    <td>Test3</td>
                </tr>
            </table>   
            <?php
                //Gibt alle E-Mail Labels des Accounts aus
                $user = 'me';
//                $results = $gmail_service->users_labels->listUsersLabels($user);

                $q = ' after:2016/11/7';
                fetchMails($gmail_service);
//                getMessage($gmail_service, '1638506ae099f27d');
            ?>
        </section>
    </body>
</html>