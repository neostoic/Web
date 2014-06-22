<?php

if(!file_exists('./vendor/autoload.php')){
  die("You need to run <em>php composer.phar update</em> in the root directory.");
}
require_once("./vendor/autoload.php");

require_once("./src/config/config.php");

//Reduce errors
error_reporting(~E_WARNING);

Eventsd\PacketProcessor::bind_on_event_callback(function(\Eventsd\Models\Occurrence $occurrence){
  $fp = fsockopen('127.0.0.1', 8080, $errno, $errstr, 30);
  if (!$fp) {
    echo "$errstr ($errno)<br />\n";
  } else {
    $out = $occurrence->__toJson();
    fwrite($fp, $out);
    fclose($fp);
  }
});

Eventsd\PacketProcessor::create_socket_server(EVENTSD_BIND, EVENTSD_PORT);