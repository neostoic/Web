<?php
$start = microtime(true);
require_once("vendor/eventsd/eventsd/Eventsd/Exception.php");
require_once("vendor/eventsd/eventsd/Eventsd/Datagram.php");
require_once("vendor/eventsd/eventsd/Eventsd/DatagramException.php");
require_once("vendor/eventsd/eventsd/Eventsd/DatagramHydrationException.php");
require_once("vendor/eventsd/eventsd/Eventsd/DatagramSizeException.php");
require_once("vendor/eventsd/eventsd/Eventsd/Eventsd.php");
require_once("vendor/fouroneone/activerecord/FourOneOne/ActiveRecord/UUID.php");
\Eventsd\Eventsd::configure(array(
  'Server' => 'localhost',
  'Port' => 3465,
  'Key' => 'fe451eb5-6c97-491e-9a66-23c7b4d528aa',
));

$delay = microtime(true) - $start;
\Eventsd\Eventsd::trigger("loadtest", json_encode(array('uuid' => \FourOneOne\ActiveRecord\UUID::v4(), 'url'=>$_SERVER['REQUEST_URI'], 'delay' => $delay)));

header("Content-type: text/plain");
echo "OK.\n";
echo "Complete in ". $delay . " seconds.";