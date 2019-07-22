<?php

namespace core;

abstract class Debug {

    /**
     * Apenas uma função utilitária
     *
     * @param  mixed $args
     *
     * @return void
     */
    public static function log($args){
        ob_start();
        ob_clean();
            echo "<pre>";
            var_dump($args);
            echo "</pre>";
        ob_get_contents();
        ob_end_flush();
        exit();
    }
    
}
