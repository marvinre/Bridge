<?php
/*****************************************************************
*
*           DRAFTS FUNCTIONS
*
*****************************************************************/

function createDraft($service, $user, $message) {
    $draft = new Google_Service_Gmail_Draft();
    $draft->setMessage($message);
    try {
        $draft = $service->users_drafts->create($user, $draft);
        print 'Draft ID: ' . $draft->getId();
    } catch (Exception $e) {
        print 'An error occurred: ' . $e->getMessage();
    }
    return $draft;
}



function createMessage($email) {
    $message = new Google_Service_Gmail_Message();
    // base64url encode the string
    //   see http://en.wikipedia.org/wiki/Base64#Implementations_and_history
    $email = strtr(base64_encode($email), array('+' => '-', '/' => '_'));
    $message->setRaw($email);
    return $message;
}





/*****************************************************************
*
*           MAIL FUNCTIONS
*
*****************************************************************/

//Shows mail with specific ID from user 
function getMessage($service, $userId, $messageId) {
    try {
        $message = $service->users_messages->get($userId, $messageId);
        print 'Message with ID: ' . $message->getId() . ' retrieved.';
        return $message;
    } catch (Exception $e) {
        print 'An error occurred: ' . $e->getMessage();
    }
}

function sendMessage($service, $userId, $message) {
  try {
    $message = $service->users_messages->send($userId, $message);
    print 'Message with ID: ' . $message->getId() . ' sent.';
    return $message;
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }
}

?>