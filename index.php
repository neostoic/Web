<?php
require_once("bootstrap.php");

// Allow CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header("Access-Control-Allow-Headers: *");
}
\Eventsd\Eventsd::trigger("visitor", $_SERVER['REQUEST_URI']);

// Initialise app.
$app = new \Slim\Slim(array(
  'templates.path' => './templates',
));
$session = new \FourOneOne\Session();

// Load themes
require_once("themes/Base/base.inc");
require_once("themes/" . THEME . "/template.inc");

// Load all controllers.
$file_list = scandir("./src/controllers/{$mode}");
sort($file_list);
foreach($file_list as $file){
  switch($file){
    case '.':
    case '..':
      // Do nothing
      break;
    default:
      if(is_file("./src/controllers/{$mode}/{$file}")){
        require_once("./src/controllers/{$mode}/{$file}");
      }
  }
}

$app->view()->setSiteTitle(APP_NAME);
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);
$app->run();

\Eventsd\Eventsd::trigger("request_latency", json_encode(array('url'=>$_SERVER['REQUEST_URI'], 'delay' => microtime(true) - TIME_STARTUP)));



