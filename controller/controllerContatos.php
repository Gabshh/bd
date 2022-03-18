<?php
    /*************************************************************************************
     * Objetivo: Arquivo responsável pela manipulação de dados de contatos
     * Obs (Este arquivo fará a ponte entre a View e a Model)
     * Dev: Gabriel Gomes
     * Data: 18/03/2022
     * Versão: 2.0
     ************************************************************************************/

    // Função para receber dados da View e encaminhar para a Model (Inserir)
    function inserirContato($dadosContato) {
        // Validação para verificar se  o objeto esta vazio
        if(!empty($dadosContato)){
            /*
             Validação de caixa vazia dos elementos nome celular e email,
             pois são obrigatórios no BD
            */
            if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && 
               !empty($dadosContato['txtEmail'])){ 
                /* 
                Criação do array de dados que será encaminhado a model para inserir no BD,
                é importante criar esse array conforme as necessidades de manipulação do BD
                OBS: criar as chaves do array conforme os nomes dos atributos do BD
                */
                $arrayDados = array(
                    "nome" => $dadosContato['txtNome'],
                    "telefone" => $dadosContato['txtTelefone'],
                    "celular" => $dadosContato['txtCelular'],
                    "email" => $dadosContato['txtEmail'],
                    "obs" => $dadosContato['txtObs'],
                );

                //import do arquivo de modelagem para manipular o BD
                require_once('model/bd/contato.php');
                //Chama a função que fará o insert no BD (esta função está na model)
                if(insertContato($arrayDados))
                    return true;
                else
                    return array('idErro' => 1,
                                'message' => 'Não foi possível inserir os dados no Banco de Dados');

            }
            else
                return array('idErro' => 2,
                            'message' => 'Existem campos obrigatórios que não foram preenchidos.');
        }
        

    }

    //Função para receber dados da View e encaminhar para a Model (Atualizar)
    function atualizarContato() {
        
    }

    //Função para realizar a exclusão de um contato
    function excluirContato() {
        
    }

    //Função para solicitar os dados da Model e encamminhar a lista de contatos para a View
    function listarContato() {
        //Import do arquivo que vai buscar os dados
        require_once('model/bd/contato.php');

        //Chama a função que vai buscar os dados no BD
        $dados = selectAllContatos();

        if(!empty($dados)){
            return $dados;
        }else{
            return false;
        }
    }

?>