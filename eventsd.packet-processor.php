<?php

//Set the ticks
declare(ticks = 1);


//Check to make sure the forked ok.

if(!file_exists('./vendor/autoload.php')){
  die("You need to run <em>php composer.phar update</em> in the root directory.");
}
require_once("./vendor/autoload.php");

require_once("./src/config/config.php");
$redis = new \Predis\Client();
//$redis->flushall();exit;

//Reduce errors
error_reporting(~E_WARNING);

$redis = new \Predis\Client();

while(true){
  $queue = $redis->llen('events_que');
  echo "Queue: " . $queue . "\n";
  if($queue > 0){
    $pid = pcntl_fork();
    for($i=0; $i < 128; $i++){
      if ($pid == -1) {
        die('could not fork');
      } else if ($pid) {
        // we are the parent
      } else {
        sleep(3);

        // we are the child
        $buf = $redis->lpop('events_que');
        echo "Buf: {$buf}\n";
        if($buf !== null){
          $json = json_decode($buf);
          if(!$json){
            var_dump($buf);
          }else{
            echo "Passing to handle_packet: {$buf}\n";
            Eventsd\PacketProcessor::handle_packet($buf);
          }
        }
      }
    }
  }


  if($queue == 0){
    sleep(1);
  }
}




