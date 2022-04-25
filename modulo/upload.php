<?php 
    /************************************************************************************\
         * Objetivo: Arquivo responsavel pela criação de variáveis e constantes do projeto
         * Dev: Gabriel Gomes
         * Data: 25/04/2022
         * Versão: 1.0
    \************************************************************************************/

    // Funções para realizar upload de imagens
    function uploadFile ($arrayFile) {

        // import do arquivo de configurações do projeto
        require_once("modulo/config.php");

        $arquivo = $arrayFile;
        $sizeFile = (int) 0;
        $typeFile = (string) null;
        $nameFile = (string) null;
        $tempFile = (string) null;

        /* Validação para identificar se existe um arquivo válido (maior do que 0 
           e que tenha uma extensão) */
        if($arquivo['size'] > 0 && $arquivo['type'] != "" ) {

            // Recupera o tamanho do arquivo que é em bytes e converte para kb ( /1024)
            $sizeFile = $arquivo['size']/1024;

            // Recupera o tipo do arquivo
            $typeFile = $arquivo['type'];
       
            // Recupera o nome do arquivo
            $nameFile = $arquivo['name'];

            // Recupera o caminho do diretório temporário que está o arquivo
            $tempFile = $arquivo['tmp_name'];

            // Validação para permitir o upload apenas de arquivos de no máximo 5MB
            if ($sizeFile <= MAX_FILE_UPLOAD) {

                // Validação para permitir somente as extensões válidas
                if(in_array($typeFile, EXT_FILE_UPLOAD)) {

                    // Separa somente o nome do arquivo sem sua extensão
                    $nome = pathinfo($nameFile, PATHINFO_FILENAME);

                    // Separa somente a extensão do arquivo sem seu nome
                    $extensao = pathinfo($nameFile, PATHINFO_EXTENSION);

                    /* 
                        Existem diversos algoritmos para criptografia de dados
                            md5()
                            sha1()
                            hash()
                    */

                    // Gerando uma criptografia de dados
                    // uniqid() - gerando uma sequência numérica diferente tendo como base, configurações da máquina
                    // time()   - resgata a hora, minuto e segundo que está sendo realizado o upload da foto 
                    $nomeCripty = md5($nome.uniqid(time()));

                    // Montando novamente o nome do arquivo com a extensão 
                    $foto = $nomeCripty.".".$extensao;

                    // Envia o arquivo da pasta temporária do apache para a pasta criada no projeto
                    if ( move_uploaded_file($tempFile, DIRETORIO_FILE_UPLOAD.$foto) ) {
                        return $foto;
                    } else {
                        return array(
                            'idErro'  => 13,
                            'message' => 'Não foi possível mover o arquivo para o servidor.'
                        );    
                    }

                } else {
                    return array(
                        'idErro'  => 12,
                        'message' => 'A extensão do arquivo selecionado não é permitida no upload.'
                    );    
                }
                
            } else {
                return array(
                                'idErro'  => 10,
                                'message' => 'Tamanho de arquivo inválido no upload.'
                            );
            }

        } else {
            return array(
                            'idErro'  => 11,
                            'message' => 'Não é possível realizar o upload sem um arquivo selecionado.'
                        );
        }

    }

?>