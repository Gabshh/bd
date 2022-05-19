<?php
    /************************************************************************************************************\
     * Objetivo: Arquivo principal da API que irá receber a URL requisitada e redirecionar para as APIs (router)
     * Dev: Gabriel Gomes
     * Data: 19/05/2022
     * Versão: 1.0
    \************************************************************************************************************/

    //Permite ativar quais endereços de sites que poderão fazer requisições na API (* libera para todos os sites)
    header('Access-Controll-Allow-Origin: *');

    //Permite ativar os métodos do protocolo HTTP que irão requisitar a API
    header('Access-Controll-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

    //Permite ativar o Content-Type das requisições (Formato de dados que será utilizado (JSON, XML, FORM/DATA, etc))
    header('Access-Controll-Allow-Header: Content-Type');

    //Permite liberar quais content-type serão utilizados na API
    header('Content-Type: application/json');

    //Recebe a URL digitada na requisição
    $urlHTTP = (string) $_GET['url'];

?>