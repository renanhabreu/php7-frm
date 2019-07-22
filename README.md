# php7-frm
Framework simples em PHP7 para demonstração do funcionamento e conceituação dos roteamento de requisições GET e POST. O framework pode ser usado para a construção de aplicações e sites que não exigem muita complexidade em segurança.

# Arquitetura
A aplicação realiza uma requisição a página inicial e em seguida um objeto Router, responsável por traduzir as requisições nas chamadas ao controladores, será instanciado. O objeto Router cria uma lista de identificadores de requisição com suas respectivas chamadas de callback passando para elas a requisição em forma de objeto Request. Este objeto recebe as variáveis de $_SERVER, $_GET e $_POST tratadas. Dentro dessas callbacks do roteador é possível instanciar controladores [Controller] passando para eles o contexto da requisição, ou seja, uma instância de Request. Os controladores, antes de serem executados ou destruídos percorrem uma lista de filtros e executam o método run() definido pela interface Filter.

Request -> Router -> ( [Filter] Controller(Request) [Filter] ) 
