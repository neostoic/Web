<?php
define("TIME_STARTUP",  microtime(true));
define("WEB_HOST",      $_SERVER['HTTP_HOST']);
define("WEB_DISK_ROOT", dirname($_SERVER['SCRIPT_FILENAME']));
define("APP_DISK_ROOT", WEB_DISK_ROOT);
define("APP_ROOT",      APP_DISK_ROOT);
define("WEB_IS_SSL",    $_SERVER['SERVER_PORT']==443?true:false);
define("WEB_ROOT",      (WEB_IS_SSL?"https":"http") . "://" . $_SERVER['SERVER_NAME'] . rtrim(dirname($_SERVER['SCRIPT_NAME']),"/") . "/");
define("APP_NAME",      "Intervent.io");
define("SHOW_CUT_MARKS", false);

switch(WEB_HOST){
  default:
    define("THEME", "Eventsd");
}

// Set up error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Database Settings
switch(gethostname()){
  case 'qacha.thru.io':
    $database = new \FourOneOne\ActiveRecord\DatabaseLayer(array(
      'db_type'     => 'Mysql',
      //'db_hostname' => 'quentin.vpn.thru.io',
      'db_hostname' => '127.0.0.1',
      'db_port'     => '3306',
      'db_username' => 'events',
      'db_password' => 'SHF347GCZrcZfqZf',
      'db_database' => 'events'
    ));
    break;
  default:
    $database = new \FourOneOne\ActiveRecord\DatabaseLayer(array(
      'db_type'     => 'Mysql',
      //'db_hostname' => 'quentin.vpn.thru.io',
      'db_hostname' => '127.0.0.1',
      'db_port'     => '3306',
      'db_username' => 'eventsd',
      'db_password' => 'SHF347GCZrcZfqZf',
      'db_database' => 'eventsd'
    ));
}

define('EVENTSD_BIND', '0.0.0.0');
define('EVENTSD_PORT', '3465');
define('EVENTSD_PUBLIC_HOST', 'intervent.io');

// PHP Settings
error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(120);
ini_set('memory_limit', '32M');
date_default_timezone_set('Europe/London');

// Mail Settings
$mailer_transport = Swift_SmtpTransport::newInstance('mailserver.example.com', 465, 'ssl')
  ->setUsername('example@example.com')
  ->setPassword('password')
;
$mailer_from = array("system@example.com" => "Example");
$mailer_default_to = array("you@example.com");

\Eventsd\Eventsd::configure(array(
  'Server' => EVENTSD_PUBLIC_HOST,
  'Port' => EVENTSD_PORT,
  'Key' => 'fe451eb5-6c97-491e-9a66-23c7b4d528aa',
));
