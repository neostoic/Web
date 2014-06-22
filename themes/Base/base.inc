<?php

require_once("view-controller.inc");

$app->view(new ViewController());

$app->view()->addCSS("themes/Base" . "/css/bootstrap.css");
$app->view()->addCSS("themes/Base" . "/css/grid.css");
$app->view()->addCSS("themes/Base" . "/css/override.css");
$app->view()->addJS("themes/Base/js/jquery.min.js");
$app->view()->addJS("themes/Base/js/socket.io.js");
