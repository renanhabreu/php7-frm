# php7-frm
Framework simples em PHP7 para demonstração do funcionamento e conceituação dos roteamento de requisições GET e POST. O framework pode ser usado para a construção de aplicações e sites que não exigem muita complexidade em segurança.

# Arquitetura
O objeto Router, responsável por traduzir as requisições nas chamadas ao controladores, será instanciado. Ele é o responsável por criar uma lista de identificadores de requisição com suas respectivas chamadas de callback. Estas funções de callback registradas de acordo com os caminhos configuradosrecebem como parâmetro um objeto Request. Este objeto contém as variáveis de $_SERVER, $_GET e $_POST tratadas. Os controladores serão instanciados pelas funções de callback de cada caminho. É preciso registrar a requisição no contexto do Controller, isso se dá na instanciação. Os controladores, antes de serem executados ou destruídos percorrem uma lista de filtros e executam o método run() definido pela interface Filter. As Views, por sua vez, podem acessar todas as variáveis de contexto que existem dinamicamente dentro do objeto $view. É possível acessar as variáveis seguindo o padrão $view->nomeDaVariavel. 

Request -> Router -> ( [Filter] Controller(Request) [Filter] ) 
