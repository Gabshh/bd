<?php 
    /*************************************************************************************
         * Objetivo: Arquivo responsável pela manipulação de dados de estados
         * Obs (Este arquivo fará a ponte entre a View e a Model)
         * Dev: Gabriel Gomes
         * Data: 10/05/2022
         * Versão: 1.0
    ************************************************************************************/

    //import do arquivo de configuração do projeto
    require_once('./modulo/config.php');

    //Função para solicitar os dados da Model e encamminhar a lista de estados para a View
    function listarEstado() {
        //Import do arquivo que vai buscar os dados
        require_once('model/bd/estado.php');

        //Chama a função que vai buscar os dados no BD
        $dados = selectAllEstados();

        if(!empty($dados)){
            return $dados;
        }else{
            return false;
        }
    }

?>