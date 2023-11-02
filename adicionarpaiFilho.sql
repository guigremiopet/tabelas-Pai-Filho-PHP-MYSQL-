CREATE DEFINER=`root`@`localhost` PROCEDURE `AdicionarPaiEFilhos`(
    IN pai_nome VARCHAR(255),
    IN filhos_lista TEXT
)
BEGIN
    DECLARE id_pai INT;
    
    -- Inserir o nome do pai
    INSERT INTO Pai (Nome) VALUES (pai_nome);
    SET id_pai = LAST_INSERT_ID();
    
    -- Separar a lista de filhos em um array
    SET @filhos_array = JSON_UNQUOTE(JSON_EXTRACT(filhos_lista, '$[*]'));
    
    -- Loop para inserir cada filho
    WHILE JSON_UNQUOTE(JSON_EXTRACT(@filhos_array, '$[0]')) IS NOT NULL DO
        INSERT INTO Filho (IdPai, Name) VALUES (id_pai, JSON_UNQUOTE(JSON_EXTRACT(@filhos_array, '$[0]')));
        SET @filhos_array = JSON_REMOVE(@filhos_array, '$[0]');
    END WHILE;
    
    SELECT 'Pai e Filhos adicionados com sucesso!' AS Resultado;
END