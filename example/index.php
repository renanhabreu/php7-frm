<?php
define("APP_DIR",dirname(__FILE__));
include dirname(__FILE__).'/core/autoload.php';

use core\Router;
use core\Request;
use controller\Administrador;

$router = new Router(new Request());

//para a chamada raiz executar o método index do controller Administrador
$router->get('/', function($req) {

  $ctr = new Administrador($req);
  $ctr->index();

});




