#!/usr/bin/env php
<?php

require_once('./websockets.php');

class echoServer extends WebSocketServer {
  //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.
  
  protected function process ($user, $message) {
    $this->send($user,$message);
  }
  protected function messageProcessor($id, $message) {
      // $message = "We received: $message from user id: $id, now sending back"; 
    switch ($message) {
      case '1':
        $message = "you pressed 1";
        break;
      
      default:
        # code...
        break;
    }
    return $message;
  }
  protected function connected ($user) {
    // Do nothing: This is just an echo server, there's no need to track the user.
    // However, if we did care about the users, we would probably have a cookie to
    // parse at this step, would be looking them up in permanent storage, etc.
  }
  
  protected function closed ($user) {
    // Do nothing: This is where cleanup would go, in case the user had any sort of
    // open files or other objects associated with them.  This runs after the socket 
    // has been closed, so there is no need to clean up the socket itself here.
  }
}
// $host = 'tcp://127.0.0.1';
//$host = 'tcp://127.0.0.1';
$echo = new echoServer("0.0.0.0","9000");
//$echo = new echoServer($host,"9000");
// $echo = new echoServer("beitzprogramming.ml","443");

try {
  $echo->run();
}
catch (Exception $e) {
  $echo->stdout($e->getMessage());
}
