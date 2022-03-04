<?php 

    /*************************************************************************************
     * Objetivo: Arquivo de rota, para segmentar as ações encaminhadas pela View
     *      (dados de um form, listagem de dados, uma ação de excluir ou atualizar)
     *      Esse arquivo será responsável por encaminhar as solicitações para a Controller
     * Dev: Gabriel Gomes
     * Versão: 1.0
     * Data: 04/03/2022
     ************************************************************************************/

    $action = (string) null;
    $component = (string) null;

    //Validação para verificar se a requisição é umPOST de um formulário
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Recebendo dados via URL para saber quem esta solicitando e qual ação será 
        //realizada
        $component = strtoupper($_GET['component']);
        $action = $_GET['action'];

        //Estrutura condicional para validar quem esta solicitando algo para o Router
        switch($component){
            case 'CONTATOS':
                echo('chamando a controller de contatos');
                break; 
        }

        
    }

?>