<?php 

    // Import do arquivo de configurações do projeto
    require_once('modulo/config.php');

    $id = (int) null;

    /*Essa variável foi criada para diferenciar no action do formulário
    qual ação deveria ser levada para a router (inserir ou editar).
    Nas condções abaixo, mudamos o action dessa variável para a ação de editar*/
    $actionForm = (string) "router.php?component=contatos&action=inserir";
    
    // Variável para carregar o nome da foto no banco de dados
    $foto = (string) null;

    // variável para ser utilizada no carregar dos estados (opção de ditar)
    $id_estado = (int) null;

    //Valida se a utilização de variáveis de sessão está ativa no servidor
    if (session_status()) {
        //Processo de edição
        //Valida se a variável de sessão dadosContato não está vazia
        if (!empty($_SESSION['dadosContato'])) {
            $id         = $_SESSION['dadosContato']['id'];
            $nome       = $_SESSION['dadosContato']['nome'];
            $telefone   = $_SESSION['dadosContato']['telefone'];
            $celular    = $_SESSION['dadosContato']['celular'];
            $email      = $_SESSION['dadosContato']['email'];
            $obs        = $_SESSION['dadosContato']['obs'];
            $foto       = $_SESSION['dadosContato']['foto'];
            $id_estado  = $_SESSION['dadosContato']['id_estado'];
        
            /*Mudamos a ação do form para editar o registro no click do botão salvar */
            $actionForm = "router.php?component=contatos&action=editar&id=".$id."&foto=".$foto;

            //Destrói uma variável da memoria do servidor
            unset($_SESSION['dadosContato']);
        
        }
    }

?>

<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">

    </head>
    <body>
       
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>
                
            </div>
            <div id="cadastroInformacoes">
                <!--
                    enctype="multipart/form-data" 
                    Essa opção é obrigatória para enviar arquivos 
                    do formulário em html para o servidor 
                -->
                <form  action="<?=$actionForm?>" name="frmCadastro" method="post" enctype="multipart/form-data" >
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="nome" value="<?= isset($nome)?$nome:null ?>" placeholder="Digite seu Nome" maxlength="100">
                        </div>
                    </div>
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Estado: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <select name="estado" id="" required>
                                <option value="">Selecione um item:</option>
                                <?php 

                                    // import da controller de estados
                                    require_once('./controller/controllerEstados.php');

                                    // chama a função para carregar todos os estados no BD
                                    $listEstados = listarEstado();
                                    foreach($listEstados as $item) {
                                        ?>
                                            <option <?=$id_estado==$item['id_estado']?'selected':null?> value="<?=$item['id_estado']?>"><?=$item['nome']?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="telefone" value="<?= isset($telefone)?$telefone:null ?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="celular" value="<?= isset($celular)?$celular:null ?>">
                        </div>
                    </div>
                   
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="email" value="<?= isset($email)?$email:null ?>">
                        </div>
                    </div>

                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Escolha um arquivo: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="file" name="foto" accept="/img*">
                        </div>
                    </div>

                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="obs" cols="50" rows="7"><?= isset($obs)?$obs:null ?></textarea>
                        </div>
                    </div>
                    
                    <div class="campos">
                        <img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>" alt="fotinha">
                    </div>

                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas destaque"> Nome </td>
                    <td class="tblColunas destaque"> Celular </td>
                    <td class="tblColunas destaque"> Email </td>
                    <td class="tblColunas destaque"> Fotinha </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>
                
               <?php
               
                    //Import do arquivo da controller para solicitar a listagem dos dados
                    require_once('controller/controllerContatos.php');
                    //Chama a função que vai retornar os dados de contatos
                    $listContato = listarContato();

                    //Estrutura de repetição para retirar os dados do array e printar na tela
                    if(!empty($listContato)) {
                        foreach($listContato as $item) {

                            // Variável para carregar a foto que veio do BD
                            $foto = $item['foto'];
               ?>

                    <tr id="tblLinhas">
                        <td class="tblColunas registros"><?=$item['nome']?></td>
                        <td class="tblColunas registros"><?=$item['celular']?></td>
                        <td class="tblColunas registros"><?=$item['email']?></td>
                        <td class="tblColunas registros"> <img src="<?=DIRETORIO_FILE_UPLOAD.$foto?>" alt="fotinha" class="foto" > </td>
                    
                        <td class="tblColunas registros">
                            <a href="router.php?component=contatos&action=buscar&id=<?=$item['id']?>">
                                <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                            </a>

                            <a onclick="return confirm('Deseja realmente excluir esse item?');" href="router.php?component=contatos&action=deletar&id=<?=$item['id']?>&foto=<?=$foto?>">
                                <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir">
                            </a>

                            <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                        </td>
                    </tr>

                <?php
                        }
                    }
                ?>

            </table>
        </div>
    </body>
</html>