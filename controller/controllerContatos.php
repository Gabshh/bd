<?php
    /*************************************************************************************
     * Objetivo: Arquivo responsável pela manipulação de dados de contatos
     * Obs (Este arquivo fará a ponte entre a View e a Model)
     * Dev: Gabriel Gomes
     * Data: 01/04/2022
     * Versão: 2.0
     ************************************************************************************/

    //import do arquivo de configuração do projeto
    require_once(SRC.'./modulo/config.php');

    // Função para receber dados da View e encaminhar para a Model (Inserir)
    function inserirContato($dadosContato, $file) {

        $nomeFoto = (string) null;

        // Validação para verificar se  o objeto esta vazio
        if(!empty($dadosContato)){
            /*
             Validação de caixa vazia dos elementos nome celular e email,
             pois são obrigatórios no BD
            */
            if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && 
               !empty($dadosContato['txtEmail'])){ 
                
                // Validação para identificar se chegou um arquivo para upload
                if ($file['fileFoto']['name'] != null) {

                    // import da função de upload
                    require_once('modulo/upload.php');

                    // chama a função de upload
                    $nomeFoto = uploadFile($file['fileFoto']);
                    
                    if (is_array($nomeFoto)) {
                        /* Caso aconteça algum erro no processo de upload, 
                        a função irá retornar um array com a possível mensagem de erro. 
                        Esse array será retornado para a router e ela irá exibir a mensagem para o usuário */
                        return $nomeFoto;
                    }

                }
                
                /* 
                Criação do array de dados que será encaminhado a model para inserir no BD,
                é importante criar esse array conforme as necessidades de manipulação do BD
                OBS: criar as chaves do array conforme os nomes dos atributos do BD
                */
                $arrayDados = array(
                    "nome"      => $dadosContato['txtNome'],
                    "telefone"  => $dadosContato['txtTelefone'],
                    "celular"   => $dadosContato['txtCelular'],
                    "email"     => $dadosContato['txtEmail'],
                    "obs"       => $dadosContato['txtObs'],
                    "foto"      => $novaFoto,
                    "id_estado" => $dadosContato['sltEstado']
                );

                //import do arquivo de modelagem para manipular o BD
                require_once('model/bd/contato.php');
                //Chama a função que fará o insert no BD (esta função está na model)
                if(insertContato($arrayDados))
                    return true;
                else
                    return array('idErro' => 1,
                                'message' => 'Não foi possível inserir os dados no banco de dados.');

            }
            else
                return array('idErro' => 2,
                            'message' => 'Existem campos obrigatórios que não foram preenchidos.');
        }
        

    
    }

    //Função para buscar um contato através do id do registro
    function buscarContato($id) {
        //Validação para verificar se id contém um número válido
        if($id != 0 && !empty($id) && is_numeric($id)) {
            
            //Import do arquivo de contato
            require_once(SRC.'model/bd/contato.php');

            //Chama a função na model que vai buscar no BD
            $dados = selectByIdContato($id);

            //Valida se existem dados para serem devolvidos
            if(!empty($dados)) {
                return $dados;
            }else{
                return false;
            }

        } else {
            return array('idErro' => 4,
                        'message' => 'Não é possível buscar o registro sem informar um id válido.');
        }
    }

    //Função para receber dados da View e encaminhar para a Model (Atualizar)
    function atualizarContato($dadosContato, $id) {

        $statusUpload = (boolean) false;

        require_once('model/bd/contato.php');

        // Recebe o id enviado pelo arrayDados
        $id = $arrayDados['id'];

        // Recebe a foto enviada pelo arrayDados (Nome da foto que ja existe no BD)
        $foto = $arrayDados['foto'];

        // Recebe o objeto de array referente a nova foto que poderá ser enviada ao servidor
        $file = $arrayDados['file'];

         // Validação para verificar se  o objeto esta vazio
        if(!empty($dadosContato)){
            /*
             Validação de caixa vazia dos elementos nome celular e email,
             pois são obrigatórios no BD
            */
            if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && 
               !empty($dadosContato['txtEmail'])){ 

                //Validação para garantir que o id seja válido
                if(!empty($id) && $id != 0 && is_numeric($id) ){

                    // Validação para identificar se será enviado ao servidor uma nova foto
                    if($file['fileFoto']['name'] != null) {

                        // import da função de upload
                        require_once('modulo/upload.php');


                        // chama a função de upload para enviar a nova foto ao servidor
                        $novaFoto = uploadFile($file['fileFoto']);
                        $statusUpload = true;

                    } else {
                        //permanece a mesma foto no BD
                        $novaFoto = $foto;
                    }

                    
                    /* 
                    Criação do array de dados que será encaminhado a model para inserir no BD,
                    é importante criar esse array conforme as necessidades de manipulação do BD
                    OBS: criar as chaves do array conforme os nomes dos atributos do BD
                    */
                    $arrayDados = array(
                        "id"        => $id,
                        "nome"      => $dadosContato['txtNome'],
                        "telefone"  => $dadosContato['txtTelefone'],
                        "celular"   => $dadosContato['txtCelular'],
                        "email"     => $dadosContato['txtEmail'],
                        "obs"       => $dadosContato['txtObs'],
                        "foto"      => $novaFoto,
                        "id_estado" => $dadosContato['sltEstado']
                    );

                    //import do arquivo de modelagem para manipular o BD
                    require_once('model/bd/contato.php');
                    //Chama a função que fará o update no BD (esta função está na model)
                    if(updateContato($arrayDados)){

                        // Validação para verificar se será necessário apagar a foto antiga
                        // está variável foi ativada em true na linha 138 quando realizamos o upload de uma nova foto para o servidor
                        if ($statusUpload) {
                            // apaga a foto antiga da pasta do servidor
                            unlink(DIRETORIO_FILE_UPLOAD.$foto);
                        }
                        return true;
                    }
                        
                    else {
                        return array(
                                    'idErro' => 1,
                                    'message' => 'Não foi possível atualizar os dados no banco de dados.'
                                    );
                    }

                }else{
                    return array(
                                'idErro' => 4,
                                'message' => 'Não é possível editar o registro sem informar um id válido.'
                                );
                } 

            } else
                return array('idErro' => 2,
                            'message' => 'Existem campos obrigatórios que não foram preenchidos.');
        }
    }

    //Função para realizar a exclusão de um contato
    function excluirContato($arrayDados) {

        // Recebe o id do registro que será excluído
        $id = $arrayDados['id'];
        
        // Recebe o nome da foto que será excluída da pasta do servidor
        $foto = $arrayDados['foto'];

        //Validação para verificar se id contém um número válido
        if($id != 0 && !empty($id) && is_numeric($id)) {

            //Import do arquivo de contato
            require_once('model/bd/contato.php');
            // Import dp arquivo de configurações do projeto
            require_once('modulo/config.php');
            
            //Chama a função da model e valida se o retorno foi verdadeiro ou falso
            if(deleteContato($id)){

                // Validação para caso a foto não exista com o registro
                if ($foto != null) {
                    
                    // unlink() - função para apagar um arquivo de um diretório
                    // Permite apagar a foto fisicamente do diretório no servidor
                    if(unlink(DIRETORIO_FILE_UPLOAD.$foto)) {
                        return true;
                    }else {    
                        return array('idErro' => 5,
                        'message' => 'O registro do banco de dados foi excluído com sucesso, 
                                    porém a imagem não foi excluída do diretório do servidor.');
                    }
                } else {
                    return true;
                }

            }else{
                return array('idErro' => 3,
                            'message' => 'O banco de dados não pode excluir o registro.');
            }
        }else{
            return array('idErro' => 4,
                        'message' => 'Não é possível excluir o registro sem informar um id válido.');
        }
    }

    //Função para solicitar os dados da Model e encamminhar a lista de contatos para a View
    function listarContato() {
        //Import do arquivo que vai buscar os dados
        require_once(SRC.'model/bd/contato.php');

        //Chama a função que vai buscar os dados no BD
        $dados = selectAllContatos();

        if(!empty($dados)){
            return $dados;
        }else{
            return false;
        }
    }

?>