<?php

namespace core;
use core\Debug;

/**
 * Classe responsavel por fazer o roteamento das requisições.
 * Ela trabalha identificando quais os controladores deverão
 * ser executados, passando para seu contexto as requisições
 * já tratadas.
 * 
 * Esta classe trata apenas dois tipos de requisições:
 * GET e POST. O tratamento e verificação é realizado no método
 * mágico chamado __call.
 * 
 * @author Renan Abreu <renanhabreu@gmail.com>
 * @package core
 */
Class Router{
    
    private $request;
    private $supportedHttpMethods = array("GET","POST");

    /**
     * Recebe, obrigatoriamente, uma requisição.
     * Cada controlador tem sua própria requisição
     *
     * @param  core\Request $req
     *
     * @return void
     */
    public function __construct(Request $req){
        $this->request = $req;
    }
    
    
    /**
     * Esta função mágica recebe o nome de uma função inexistente na classe
     * e verifica que é GET ou POST. Caso seja um desses nomes então a requisição
     * será tratada. Os argumentos são o caminho a ser roteado e uma função de 
     * callback. É nesta função de callback que se pode instanciar um controllador
     * ou uma view.
     *
     * @param  mixed $name
     * @param  mixed $args
     *
     * @return void
     */
    public function __call($name, $args){
        list($route,$method) = $args;
        if(!in_array(strtoupper($name), $this->supportedHttpMethods)){
            //header("{$this->request->serverProtocol} 405 Controller Not Allowed"); 
            Debug::log($this->supportedHttpMethods . ": Metodo não suportado");
        }
        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Formada o caminho para realizar o roteamento
     *
     * @param  string $route
     *
     * @return string
     */
    private function formatRoute(string $route){
        $result = rtrim($route,"/");
       
        return ($result === "") ? "/" : $result;
    }

    
    /**
     * Retorna a URI configurada no caso de requisicoes GET
     *
     * @return string
     */
    private function getRouteUri(){
        $_uri = explode(".php",$this->request->requestUri);
        

        if (sizeof($_uri) == 1 || (sizeof($_uri) == 2 && $_uri[1] == "" )){ 
            return  "/";
        }else if((sizeof($_uri) == 2 && $_uri[1] == "/" )){
            return "/";
        }else{
            return "/".$this->formatRoute(explode("/",$_uri[1])[1]);
            
        }
        
    }

    
    /**
     * Requisição padrao caso nenhum dado seja configurado no roteamento
     *
     * @return void
     */
    private function defaultRequest(){
        header("{$this->request->serverProtocol} 405 Controller Not Allowed");  
        //Debug::log( "Requisição não resolvida"); 
    }
    
    
    /**
     * Esta função resolve o roteamento. Ao identificar a função de callback
     * o roteador faz a chamada passando como parâmetro um objeto Request.
     * Desse modo, a função de callback conhece todo o contexto da requisição
     *
     * @return void
     */
    private function resolve(){
        $dicMethods = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->getRouteUri();
       
        if(array_key_exists($formatedRoute,$dicMethods)){
            $method = $dicMethods[$formatedRoute];
            if(is_null($method)){
                $this->defaultRequest();
                return;
            }
            call_user_func_array($method, array($this->request));
        }else{
            $this->defaultRequest();
            return;
        }
        

    }

    public function __destruct(){
        $this->resolve();        
    }
}