<?php

if(!file_exists('./vendor/autoload.php')){
  die("You need to run <em>php composer.phar update</em> in the root directory.");
}
require_once("./vendor/autoload.php");

require_once("./src/config/config.php");


//Reduce errors
error_reporting(~E_WARNING);

Eventsd\PacketProcessor::bind_on_event_callback(function(\Eventsd\Models\Occurrence $occurrence){
  try{
    $occurrence->push();
  }catch(Exception $e){
    echo "**** EXCEPTION ****\n" . $e->getMessage() . "\n";
  }
});

Eventsd\PacketProcessor::create_socket_server(EVENTSD_BIND, EVENTSD_PORT);



