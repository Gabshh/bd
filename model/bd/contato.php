<?php
    /*************************************************************************************
     * Objetivo: Arquivo responsável por manipular os dados dentro do BD
     * (insert, update, select e delete)
     * Dev: Gabriel Gomes
     * Data: 11/03/2022
     * Versão: 1.0
     ************************************************************************************/

    //Import do arquivo que estabelece a conexão com o BD
    require_once('conexaoMysql.php');
     
    //Função para realizar o insert no BD
    function insertContato($dadosContato){
        
        //Declaração de variável para utilizar no return desta função
        $statusResposta = (boolean) false;
        //Abre a conexão com o BD 
        $conexao = conexaoMysql();
        
        //Monta o script para enviar para o BD
        $sql = "insert into table_contatos 
                    (
                    nome,
                    telefone,
                    celular,
                    email, 
                    obs,
                    foto
                    ) 
                values 
                    (
                    '".$dadosContato['nome']."', 
                    '".$dadosContato['telefone']."', 
                    '".$dadosContato['celular']."', 
                    '".$dadosContato['email']."', 
                    '".$dadosContato['obs']."',
                    '".$dadosContato['foto']."'
                    );";
        
        //echo($sql);

        //Executa o script no BD
            //Validação para verificar se o script sql está correto
        if (mysqli_query($conexao, $sql)) {
            
            //Validação para verificar se uma linha foi acrescentada no BD
            if(mysqli_affected_rows($conexao)) { 
                $statusResposta = true;
            }
            
        }

        //Solicita o fechamento da conexão com o BD
        fecharConexaoMysql($conexao);
        
        return $statusResposta;
        
    }

    //Função para buscar um contato no BD através do id do registro
    function selectByIdContato($id){
        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        //Script para listar todos os dados do BD
        $sql = "select * from table_contatos where id_contato = ".$id;
        
        //Executa o script sql no BD e guarda o retorno dos dados, se houver
        $result = mysqli_query($conexao, $sql);

        //Valida se o BD retornou registros
        if($result){

            /* mysqli_fetch_assoc() - permite converter os dados do BD 
            em um array para manipulação no PHP
            Nesta repetição estamos convertendo os dados do BD em um array ($rsDados),
            além de o próprio while conseguir gerenciar a qtde de vezes que deverá ser
            feita a repetição*/

            if ($rsDados = mysqli_fetch_assoc($result)) {

                //Cria um array com os dados do BD
                $arrayDados = array(
                    "id"        => $rsDados['id_contato'],
                    "nome"      => $rsDados['nome'],
                    "telefone"  => $rsDados['telefone'],
                    "celular"   => $rsDados['celular'],
                    "email"     => $rsDados['email'],
                    "obs"       => $rsDados['obs'],
                    "foto"      => $rsDados['foto']             
                );

            }

            // }

            //Solicita o fechamento da conexão com o BD
            fecharConexaoMysql($conexao);

            return $arrayDados;
        }
    }

    //Função para realizar o update no BD
    function updateContato($dadosContato){

        //Declaração de variável para utilizar no return desta função
        $statusResposta = (boolean) false;
        //Abre a conexão com o BD 
        $conexao = conexaoMysql();
        
        //Monta o script para enviar para o BD
        $sql = "update table_contatos set
                    
                    nome         = '".$dadosContato['nome']."',
                    telefone     = '".$dadosContato['telefone']."',
                    celular      = '".$dadosContato['celular']."',
                    email        = '".$dadosContato['email']."', 
                    obs          = '".$dadosContato['obs']."',
                    foto          = '".$dadosContato['foto']."'

                where id_contato = ".$dadosContato['id'];
                     
        //echo($sql);

        //Executa o script no BD
            //Validação para verificar se o script sql está correto
        if (mysqli_query($conexao, $sql)) {
            
            //Validação para verificar se uma linha foi acrescentada no BD
            if(mysqli_affected_rows($conexao)) { 
                $statusResposta = true;
            }
            
        }

        //Solicita o fechamento da conexão com o BD
        fecharConexaoMysql($conexao);
        
        return $statusResposta;
    }

    //Função para excluir no BD
    function deleteContato($id){

        ////Declaração de variável para utilizar no return desta função
        $statusResposta = (boolean) false;

        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        $sql = "delete from table_contatos where id_contato = ".$id;

        //Valida se o script eta correto, sem erro de sintaxe e executa no BD
        if(mysqli_query($conexao, $sql)) {

            //Valida se o BD teve sucesso na execução do script
            if(mysqli_affected_rows($conexao)){
                $statusResposta = true;
            }

        }

        fecharConexaoMysql($conexao);
        return $statusResposta;

    }

    //Função para listar todos os contatos no BD
    function selectAllContatos(){
        //Abre a conexão com o BD
        $conexao = conexaoMysql();

        //Script para listar todos os dados do BD
        $sql = "select * from table_contatos order by id_contato desc";
        
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
                    "id"        => $rsDados['id_contato'],
                    "nome"      => $rsDados['nome'],
                    "telefone"  => $rsDados['telefone'],
                    "celular"   => $rsDados['celular'],
                    "email"     => $rsDados['email'],
                    "obs"       => $rsDados['obs'],
                    "foto"      => $rsDados['foto']              
                );
                $cont++;

            }

            //Solicita o fechamento da conexão com o BD
            fecharConexaoMysql($conexao);

            return @$arrayDados;
        }
    }
?>