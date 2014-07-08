<?php

//Set the ticks
declare(ticks = 1);

//Fork the current process
$processID = pcntl_fork();

//Check to make sure the forked ok.
if ( $processID == -1 ) {
  echo "\n Error:  The process failed to fork. \n";
} else if ( $processID ) {
  die("Intervent UDP Service: Forked as $processID\n");
  exit;
} else {

  if(!file_exists('./vendor/autoload.php')){
    die("You need to run <em>php composer.phar update</em> in the root directory.");
  }
  require_once("./vendor/autoload.php");

  require_once("./src/config/config.php");
  $redis = new \Predis\Client();

  //Reduce errors
  error_reporting(~E_WARNING);

  Eventsd\PacketProcessor::bind_on_event_callback(function(\Eventsd\Models\Occurrence $occurrence){
    return false;
    try{
      $occurrence->push();
    }catch(Exception $e){
      echo "**** EXCEPTION ****\n" . $e->getMessage() . "\n";
    }
  });

  Eventsd\PacketProcessor::create_socket_server(EVENTSD_BIND, EVENTSD_PORT);

}

