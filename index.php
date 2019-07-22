<?php
define("APP_DIR",dirname(__FILE__));
include dirname(__FILE__).'/core/autoload.php';

use core\Router;
use core\Request;
use filter\Login;
use filter\Logout;
use controller\Teste;

$router = new Router(new Request());
$router->get('/', function($req) {
    $ctr = new Teste(
        $req, 
        array(new Login()),
        array(new Logout())
    );
    $ctr->index();   
});

$router->post('/contar', function($req) {
    $ctr = new Teste($req);
    $ctr->contar();   
});


