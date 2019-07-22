<?php


// DIRECTORY_SEPARATOR alias
define("DS", DIRECTORY_SEPARATOR);
define("CORE_DIR", __DIR__ . DS);

if(!defined("APP_DIR")){
    define("APP_DIR", "." . DS);
}



/**
 * Includes automático da classes do aplicativo.
 * @author Renan Abreu <renanhabreu@gmail.com>
 * @package core
 */
spl_autoload_register(function($class_name){

    $class_name = strtolower($class_name);
    if (!class_exists($class_name)) {

       //busca os arquivo núcleos da aplicação
       $framework_dir = CORE_DIR . str_replace("\\",DS, $class_name) . '.php';  
       if (file_exists($framework_dir)) {
            require_once($framework_dir);
            return;
        }

        //busca os arquivos da aplicação. O nome das pastas deve ser o mesmo do pacote
        $application_dir = APP_DIR . DS . str_replace("\\",DS, $class_name) . '.php';  
        if (file_exists($application_dir)) {
            require_once($application_dir);
            return;
        }

        throw new Exception("Classe $class_name nao encontrada", 1);
        
    }
});
