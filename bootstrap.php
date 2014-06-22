<?php

if(!file_exists('./vendor/autoload.php')){
  die("You need to run <em>php composer.phar update</em> in the root directory.");
}

// Load Auto loaded things
require_once("./vendor/autoload.php");
require_once("./vendor/fouroneone/session/FourOneOne/Session/Session.php");

// Load not-autoloaded-things
require_once("./src/config/config.php");
require_once("./src/config/foursquare.php");
require_once("./src/config/google.php");
require_once("./src/lib/mail.php");

// Decide if we're the API version or the Web version
if(substr($_SERVER['SERVER_NAME'], 0, 4) == 'api.'){
  $mode = 'api';
}else{
  $mode = "web";
}


