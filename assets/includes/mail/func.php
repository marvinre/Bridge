<?php

//GMail func.php


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
?>