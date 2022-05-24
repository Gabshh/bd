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
            return $response    ->  withStatus ( 204 );
                                // ->  withHeader ( 'Content-Type', 'application/json' )
                                // ->  write      ( '{"message": "Item não encontrado"}' );
        }
        
    });

    // EndPoint: Requisição para listar todos os contatos pelo id
    $app->get('/contatos/{id}', function($request, $response, $args) {
        
        // Recebe o ID do registro que deverá ser retornado pela API 
        // Esse ID está chegando pela variável criada no endpoint
        $id = $args['id'];

        // import da controller de contatos, que fará a busca de dados
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');
        
        // Solicita os dados para a controller
        if($dados = buscarContato($id)) {

            // Verifica se houve algum tipo de erro no retorno dos dados da controller
            if(!isset($dados['idErro'])) {

                // Realiza a conversão do array de dados em formato JSON
                if($dadosJSON = createJSON($dados)) {

                    // Caso exista dados a serem retornados, informamos o statusCode 200 
                    // e enviamos um JSON com todos os dados encontrados
                    return $response    ->  withStatus ( 200 )
                                        ->  withHeader ( 'Content-Type', 'application/json' )
                                        ->  write      ( $dadosJSON );
                }
            } else {
                // Converte o erro para JSON, pois a controller retorna em array
                $dadosJSON = createJSON($dados);

                // Retorna um erro que significa que o cliente passou dados errados
                return $response    ->  withStatus ( 400 )
                                    ->  withHeader ( 'Content-Type', 'application/json' )
                                    ->  write      ( '{"message": "Dados inválidos",
                                                          "Erro": '.$dadosJSON.' }');
            }

        } else {
            // retorna um statusCode que significa que a requisição foi aceita, porém sem conteúdo de retorno
            return $response    ->  withStatus ( 404 )
                                ->  withHeader ( 'Content-Type', 'application/json' )
                                ->  write      ( '{"message": "Item não encontrado"}' );
        }
        
        // echo($id);
        // die;
    });

    // EndPoint: requisição para deletar um contato pelo id
    $app->delete('/contatos/{id}', function($request, $response, $args) {
        
        if(isset($args['id']) && is_numeric($args['id'])) {
            
            // import da controller de contatos, que fará a busca de dados
            require_once('../modulo/config.php');
            require_once('../controller/controllerContatos.php');
            
            $id = $args['id'];
            
            // Busca o nome da foto para ser excluida na controller
            if( $dados = buscarContato($id) ) {
                
                // Recebe o nome da foto que a controller retornou
                $foto = $dados['foto'];
                
                // Cria um array com o ID e o nome da foto a ser enviada para a controller excluir o registro
                $arrayDados = array (
                    "id"   => $id,
                    "foto" => $foto
                );

                $resposta = excluirContato($arrayDados);
                // Chama a função de excluir o contato, encaminhando o array com o ID e a foto
                if(is_bool($resposta) && $resposta == true) {
                    
                    return $response    ->  withStatus ( 200 )
                                        ->  withHeader ( 'Content-Type', 'application/json' )
                                        ->  write      ( '{"message": "Registro excluído com sucesso."}' );

                } elseif (is_array($resposta) && isset($resposta['idErro'])){
                    
                    // Validação referente ao eerro 5 que significa que o registro foi excluído do BD e a imagem não existia
                    if($resposta['idErro'] == 5) {

                        return $response    ->  withStatus ( 200 )
                                            ->  withHeader ( 'Content-Type', 'application/json' )
                                            ->  write      ( '{"message": "Registro excluído com sucesso, porém houve um problema na exclusão da imagem no servidor"}' );

                    } else {

                        // Converte o erro para JSON, pois a controller retorna em array
                        $dadosJSON = createJSON($resposta);

                        // Retorna um erro que significa que o cliente passou dados errados
                        return $response    ->  withStatus ( 404 )
                                            ->  withHeader ( 'Content-Type', 'application/json' )
                                            ->  write      ( '{"message": "Houve um problema no processo de excluir",
                                                                "Erro": '.$dadosJSON.' }');                        
                    }

                }
            
            } else {
                // Retorna um erro que significa que o cliente informou um ID inválido
                return $response    ->  withStatus ( 404 )
                                    ->  withHeader ( 'Content-Type', 'application/json' )
                                    ->  write      ( '{"message": "O ID informado não existe na base de dados."}' );
            }

        } else {
            // Retorna um erro que significa que o cliente passou dados errados
            return $response    ->  withStatus ( 404 )
                                ->  withHeader ( 'Content-Type', 'application/json' )
                                ->  write      ( '{"message": "É obrigatório informar um ID com formato válido"}' );
        }

    });

    // EndPoint: Requisição para listar todos os contatos
    $app->post('/contatos', function($request, $response, $args) {

    });

    // Executa todos os EndPoints
    $app->run();
?>