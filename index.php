<?php

ini_set('display_errors', 1);
define('SERVER', 'localhost');
define('DBNAME', 'teste');
define('USER', 'root');
define('PASSWORD', 'Pettersen.18');

try {
    $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    $Conexao = new PDO("mysql:host=" . SERVER . ";dbname=" . DBNAME, USER, PASSWORD, $opcoes);
    $SQL = 'CALL GetPaiFilhosJSON();';
    $STM = $Conexao->prepare($SQL);
    $STM->execute();
    $dados = $STM->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($dados)) {
        foreach ($dados as $item) {
            $json = json_decode($item['DATA_RESULT'], true);

            if (isset($json['Pai'])) {
                echo 'Nome do Pai: ' . $json['Pai'] . "<br>";

                if (isset($json['Filho'])) {
                    echo 'Nome do Filho: ' . $json['Filho'] . "<br>";
                } else {
                    echo 'Nenhum filho associado a este pai.<br>';
                }
            } else {
                echo 'Nenhum pai encontrado no JSON.<br>';
            }
        }
    } else {
        echo 'Nenhum resultado retornado pelo procedimento.<br>';
    }
} catch (PDOException $erro) {
    echo 'Mensagem de erro: ' . $erro->getMessage() . '<br>';
    echo 'Nome do Arquivo: ' . $erro->getFile() . '<br>';
    echo 'Linha: ' . $erro->getLine() . '<br>';
}
?>
