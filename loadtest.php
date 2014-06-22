<?php
$start = microtime(true);
require_once("vendor/eventsd/eventsd/Eventsd/Exception.php");
require_once("vendor/eventsd/eventsd/Eventsd/Datagram.php");
require_once("vendor/eventsd/eventsd/Eventsd/DatagramHydrationException.php");
require_once("vendor/eventsd/eventsd/Eventsd/DatagramSizeException.php");
require_once("vendor/eventsd/eventsd/Eventsd/Eventsd.php");

\Eventsd\Eventsd::configure(array(
  'Server' => 'localhost',
  'Port' => 3465,
  'Key' => 'fe451eb5-6c97-491e-9a66-23c7b4d528aa',
));

$delay = microtime(true) - $start;
\Eventsd\Eventsd::trigger("loadtest", json_encode(array('url'=>$_SERVER['REQUEST_URI'], 'delay' => $delay)));

header("Content-type: text/plain");
echo "OK.\n";
echo "Complete in ". $delay . " seconds.";