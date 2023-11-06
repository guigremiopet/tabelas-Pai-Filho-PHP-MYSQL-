CREATE DEFINER=`root`@`localhost` PROCEDURE `DeletarPaiEFilhos`(
    IN pai_id INT
)
BEGIN
    -- Deletar filhos associados ao pai
    DELETE FROM Filho WHERE IdPai = pai_id;

    -- Deletar o pai
    DELETE FROM Pai WHERE IdPai = pai_id;

    SELECT 'Pai e Filhos deletados com sucesso!' AS Resultado;
END