<?php

namespace core;

use Exception;
use core\Debug;

/**
 * Classe das visões
 * 
 * @author Renan Abreu <renanhabreu@gmail.com>
 * @package core
 */
class View{

    private $viewName = NULL;
    private $tags = array();

    public function __construct($viewName = null){
        $this->viewName = $viewName;
    }

    public function __set($name, $value){
        $this->tags[$name] = $value;    
    }

    public function __get($name){
        if(array_key_exists($name,$this->tags)){
            return $this->tags[$name];
        }
        return NULL;
    }

    public function setViewName(string $viewName){
        if(is_null($this->viewName)){
            $this->viewName = $viewName;
        }else{
            throw new Exception("View não pode ser renomeada", 1);
        }

        return;
    }

    public function show($var){
        echo $this->$var;
    }

    /**
     * Se uma variável não for null então executa uma função callback
     *
     * @param  mixed $var
     * @param  mixed $method
     *
     * @return void
     */
    public function is($var,$method){
        if(!is_null($this->$var)){
            $method($this);
        }
    }

    /**
     * Faz a renderização da View. Esse método insere
     * no contexto o objeto VIew a fim de que sias variáveis
     * estejam disponíveis para manipulação das visões;
     *
     * @return void
     */
    public function render(){
        ob_start();
        ob_clean();
        $file = APP_DIR. DS. "views" . DS . $this->viewName . ".php";
        

        if(file_exists($file)){
            $view = $this;
            include_once($file);
        }else{
            throw new Exception("View não existe", 1);
        }
       
        ob_get_contents();
        ob_end_flush();
    }

}