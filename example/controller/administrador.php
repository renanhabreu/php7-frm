<?php 

namespace controller;

use core\Controller;
use core\View;
use core\Debug;
use filter\Ativar;
use filter\Desativar;

class Administrador extends Controller {

    // metodos a título de exemplo Não são obrigatórios.
    // adicionando filtros na instanciação do objeto
    protected function __setFilter(){

        $this->filterList = array(
            new Ativar()
        );

    }

   

    public function index(){

        // lógica do negócio. Se nome for passado via GET
        // usando index.php/nome/renan
        // Request-> nome;
    
        $v = new View("administrador", $this->request);
        $v->nome= $this->request->nome;
        $v->mensagem =  "Esta é a tela inicial de demonstração do php7-frm";
        $v->render();

    }


    // metodos a título de exemplo Não são obrigatórios.
    //adicionando filtros na destruição do objeto
    protected function __setFlush(){
        
        $this->flushList = array(
            new Desativar()
        );
    }


   
}