<?php
define("APP_DIR",dirname(__FILE__));
include dirname(__FILE__).'/core/autoload.php';

use core\Router;
use core\Request;

$router = new Router(new Request());
$router->get('/', function($req) {
  //seu código   
});

$router->post('/', function($req) {
  //seu código 
});


