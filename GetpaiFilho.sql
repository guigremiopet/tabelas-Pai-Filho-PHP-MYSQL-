CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPaiFilhosJSON`()
BEGIN
    SELECT JSON_OBJECT(
        "Id", Pai.idPai,
        "Pai", Pai.Nome,
        "Filhos", JSON_ARRAYAGG(Filho.Name) 
    ) AS DATA_RESULT
    FROM Pai
    LEFT JOIN Filho ON Pai.idPai = Filho.idPai
    GROUP BY Pai.idPai, Pai.Nome;
END