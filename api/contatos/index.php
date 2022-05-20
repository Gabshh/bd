<?php 

    /*****************************************************************************\
     * 
     * $request  - Recebe dados do corpo da requisição (JSON, FORM/DATA, XML, etc)
     * $response - Envia dados de retorno da API
     * $args     - Permite receber dados de atributos na API
     * 
     \****************************************************************************/

    // import do arquivo de autoload que fará as instâncias do slim
    require_once('vendor/autoload.php');
    
    // Criando um objeto do slim chamado app, para configurar os EndPoints
    $app = new \Slim\App();

    // EndPoint: Requisição para listar todos os contatos
    $app->get('/contatos/', function($request, $response, $args) {
        // import da controller de contatos, que fará a busca de dados
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');
        
        // Solicita os dados para a controller
        if($dados = listarContato()) {

            // Realiza a conversão do array de dados em formato JSON
            if($dadosJSON = createJSON($dados)) {

                // Caso exista dados a serem retornados, informamos o statusCode 200 
                // e enviamos um JSON com todos os dados encontrados
                return $response    ->  withStatus ( 200 )
                                    ->  withHeader ( 'Content-Type', 'application/json' )
                                    ->  write      ( $dadosJSON );
            }
        } else {
            // retorna um statusCode que significa que a requisição foi aceita, porém sem conteúdo de retorno
            return $response    ->  withStatus ( 404 );
                                // ->  withHeader ( 'Content-Type', 'application/json' )
                                // ->  write      ( '{"message": "Item não encontrado"}' );
        }
        
    });

    // EndPoint: Requisição para listar todos os contatos pelo id
    $app->get('/contatos/{id}', function($request, $response, $args) {
        
        $id = $args['id'];

        // import da controller de contatos, que fará a busca de dados
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');
        
        // Solicita os dados para a controller
        if($dados = buscarContato($id)) {

            // Realiza a conversão do array de dados em formato JSON
            if($dadosJSON = createJSON($dados)) {

                // Caso exista dados a serem retornados, informamos o statusCode 200 
                // e enviamos um JSON com todos os dados encontrados
                return $response    ->  withStatus ( 200 )
                                    ->  withHeader ( 'Content-Type', 'application/json' )
                                    ->  write      ( $dadosJSON );
            }
        } else {
            // retorna um statusCode que significa que a requisição foi aceita, porém sem conteúdo de retorno
            return $response    ->  withStatus ( 404 );
                                // ->  withHeader ( 'Content-Type', 'application/json' )
                                // ->  write      ( '{"message": "Item não encontrado"}' );
        }
        
        // echo($id);
        // die;
    });

    // EndPoint: Requisição para listar todos os contatos
    $app->post('/contatos', function($request, $response, $args) {

    });

    // Executa todos os EndPoints
    $app->run();
?>