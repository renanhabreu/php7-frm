<?php

namespace core;

/**
 * Classe que possui a requisição do usuário.
 * Ela é responsável por inserir os dados da variável
 * $_SERVER, $_GET e $_POST. Também realiza o tratamentos
 * dos dados para evitar injections. 
 * 
 * @author Renan Abreu <renanhabreu@gmail.com>
 * @package core
 */
class Request{

		private $vars = array();

		public function __construct(){
			$this->initServerRequest();
		}

		/**
		 * Esta função retorna as variáveis de requisição que 
		 * foram registradas: $_SERVER, $_GET, $_POST como
		 * variáveis do objeto Request.
		 * 
		 * @param mixed $name
		 * @return mixed
		 */
		public function __get($name){

			if(array_key_exists($name,$this->vars)){
				return $this->vars[$name];
			}

			return null;
			
		}
		
		/**
		 * Busca as variáveis que estão em $_SERVER, $_GET, $_POST, 
		 * realiza as configurações para padronizacação da nomeclatura
		 * e insere seus respectivos valores no contexto da requisição
		 *
		 * @return void
		 */
		private function initServerRequest(){
			foreach($_SERVER as $key => $value){
				$this->{$this->toCamelCase($key)} = $value;
			}
			
			// o primeiro valor será o controller no caso de requisições GET
			if($this->requestMethod === "GET"){

				$_uri = explode(".php",$this->requestUri);
				
				if(sizeof($_uri) > 1 && $_uri[1] !== "" && $_uri[1] !== "/"){
					
					$uri = explode("/", rtrim($_uri[1],"/"));
					$uri_len = sizeof($uri);
					$vars = array(); 
					
					if($uri_len % 2 === 0){
						for ($i=0; $i < $uri_len; $i++) { 
							$next = $i+1;
							if($uri[$i] === "") {$uri[$i] = "controller";}
							$_GET[$uri[$i]] = $uri[$next];
							$vars[$uri[$i]] =  filter_var($uri[$next], FILTER_SANITIZE_SPECIAL_CHARS);
							
							$i = $next;
						}
					}
					$this->vars = $vars;
				}
				
			}
			
			
			if ($this->requestMethod == "POST"){
				$vars = array();
				foreach($_POST as $key => $value){
					$vars[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
				}
				$this->vars = $vars;
			}
		}

		
		/**
		 * Configura os nomes das variáveis para o objeto Request
		 *
		 * @param  mixed $string
		 *
		 * @return void
		 */
		private function toCamelCase($string){
			$result = strtolower($string);
				
			preg_match_all('/_[a-z]/', $result, $matches);
			foreach($matches[0] as $match){
				$c = str_replace('_', '', strtoupper($match));
				$result = str_replace($match, $c, $result);
			}
			return $result;
		}

		
}