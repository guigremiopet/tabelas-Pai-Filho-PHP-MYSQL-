DELIMITER //

CREATE PROCEDURE GetPaiFilhosJSON()
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE idPai INT;
    DECLARE Nome VARCHAR(255);
    DECLARE Name VARCHAR(255);
    DECLARE cur CURSOR FOR
        SELECT Pai.idPai, Pai.Nome, Filho.Name
        FROM Pai
        INNER JOIN Filho ON Pai.idPai = Filho.idPai;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
    
    SET @json = JSON_OBJECT();
    
    OPEN cur;
    
    read_loop: LOOP
        FETCH cur INTO idPai, Nome, Name;
        
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Adicione um filho ao objeto JSON manualmente
        SET @json = JSON_SET(@json, CONCAT('$.Pai[', idPai, '].Nome'), Nome);
        SET @json = JSON_SET(@json, CONCAT('$.Pai[', idPai, '].FILHOS[0].Nome'), Name);
    END LOOP;
    
    CLOSE cur;
    
    -- Remova os elementos vazios da matriz de filhos
    SET @json = JSON_REMOVE(@json, '$.Pai[0].FILHOS[1]');
    
    SELECT @json AS ResultadoJSON;
    
END //

DELIMITER ;

SELECT * FROM Pai WHERE Nome = 'Guilherme';
INSERT INTO Filho (idPai, Name) VALUES (1, 'Julio');
select *from pai;


CALL GetPaiFilhosJSON();

 SELECT Pai.idPai, Pai.Nome, Filho.Name
        FROM Pai
        INNER JOIN Filho ON Pai.idPai = Filho.idPai;