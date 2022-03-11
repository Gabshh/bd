<?php 

    /*************************************************************************************
     * Objetivo: Arquivo de rota, para segmentar as ações encaminhadas pela View
     *      (dados de um form, listagem de dados, uma ação de excluir ou atualizar)
     *      Esse arquivo será responsável por encaminhar as solicitações para a Controller
     * Dev: Gabriel Gomes
     * Versão: 2.0
     * Data: 11/03/2022
     ************************************************************************************/

    $action = (string) null;
    $component = (string) null;

    //Validação para verificar se a requisição é um POST de um formulário
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Recebendo dados via URL para saber quem esta solicitando e qual ação será 
        //realizada
        $component = strtoupper($_GET['component']);
        $action = strtoupper($_GET['action']);

        //Estrutura condicional para validar quem esta solicitando algo para o Router
        switch($component){
            case 'CONTATOS':
                
                //Import da controller Contatos
                require_once('./controller/controllerContatos.php');
                if($action == 'INSERIR')
                    inserirContato($_POST);
                elseif($action == 'EDITAR')
                    atualizarContato($_POST);
                break; 
        }

        
    }

?>