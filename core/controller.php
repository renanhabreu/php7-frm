<?php
namespace core;
use Exception;
use core\Request;
use core\Filter;

/**
 * Classe abstrata dos Controladores.
 * @author Renan Abreu <renanhabreu@gmail.com>
 * @package core
 */
abstract class Controller {
    
    protected $filterList = array();
    protected $flushList = array();
    protected $request = null;

    
    /**
     * O construtor chama a função __setFilter caso seja necessário 
     * configurar ou adicionar algum filtro. Em seguida ele percorre
     * o vertor de filtros da classe e executa a função run().
     *
     * @param  core\Request $req
     * @param  array $filterList
     * @param  array $flushList
     *
     * @return void
     */
    public function __construct(Request $req, array $filterList = array(), array $flushList = array()){

        $this->request = $req;
        $this->filterList = $filterList;
        $this->flushList = $flushList;

        $this->__setFilter();

        foreach ($this->filterList  as $key => $value) {
            if($value instanceof Filter){
               $value->run(); 
            }else{
                throw new Exception("Filtro não é uma instancia de Filter", 1);  
            }
        }
    }

    /**
     * Função protegida que é executada na instanciação 
     * e antes da execução dos filtros
     *
     * @return void
     */
    protected function __setFilter(){}

    /**
     * Função protegida que é executada na destruição do objeto
     * e antes da execução das descargas.
     *
     * @return void
     */
    protected function __setFlush(){}

    /**
     * O destrutor chama a função __setFlush caso seja necessário 
     * configurar ou adicionar alguma descarga. Em seguida ele percorre
     * o vertor de flushs da classe e executa a função run(). Os flushs
     * serão executados sempre na destruição do objeto.
     *
     * @return void
     */    
    public function __destruct(){
        $this->__setFlush();
        foreach ($this->flushList  as $key => $value) {
            if($value instanceof Filter){
               $value->run(); 
            }else{
                throw new Exception("Flush não é uma instancia de Filter", 1);  
            }
        }
    }
    
}
