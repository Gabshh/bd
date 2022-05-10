<?php 
    /*************************************************************************************
     * Objetivo: Arquivo responsável por manipular os dados dentro do BD
     * (select)
     * Dev: Gabriel Gomes
     * Data: 10/05/2022
     * Versão: 1.0
     ************************************************************************************/

     //Import do arquivo que estabelece a conexão com o BD
    require_once('conexaoMysql.php');

    
    //Função para listar todos os estados no BD
    function selectAllEstados(){
        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        //Script para listar todos os dados do BD
        $sql = "select * from table_estados order by nome asc"; // crescente
        
        //Executa o script sql no BD e guarda o retorno dos dados, se houver
        $result = mysqli_query($conexao, $sql);

        //Valida se o BD retornou registros
        if($result){

            /* mysqli_fetch_assoc() - permite converter os dados do BD 
            em um array para manipulação no PHP
            Nesta repetição estamos convertendo os dados do BD em um array ($rsDados),
            além de o próprio while conseguir gerenciar a qtde de vezes que deverá ser
            feita a repetição*/

            $cont = 0;

            while($rsDados = mysqli_fetch_assoc($result)) {

                //Cria um array com os dados do BD
                $arrayDados[$cont] = array(
                    "id_estado" => $rsDados['id_estado'],
                    "nome"      => $rsDados['nome'],
                    "sigla"     => $rsDados['sigla']             
                );
                $cont++;

            }

            //Solicita o fechamento da conexão com o BD
            fecharConexaoMysql($conexao);

            if(isset($arrayDados)) {
                return $arrayDados;
            }else {
                return false;
            }
        }
    }

?>