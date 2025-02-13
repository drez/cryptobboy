USE `gc_cryptobboy`;

DELIMITER $$

SET character_set_client = utf8$$
SET character_set_results = utf8$$
SET character_set_connection = utf8$$

DROP TRIGGER if EXISTS `asset_exchange_AFUPDATE`$$
DROP TRIGGER if EXISTS `asset_exchange_AFINSERT`$$
DROP TRIGGER if EXISTS `asset_exchange_AFDELETE`$$

CREATE TRIGGER `asset_exchange_AFINSERT` AFTER INSERT ON `asset_exchange`
FOR EACH ROW BEGIN
	CALL Asset_update( NEW.id_asset);
END$$

CREATE TRIGGER `asset_exchange_AFUPDATE` AFTER UPDATE ON `asset_exchange`
FOR EACH ROW BEGIN
	CALL Asset_update( NEW.id_asset);
END$$

CREATE TRIGGER `asset_exchange_AFDELETE` AFTER UPDATE ON `asset_exchange`
FOR EACH ROW BEGIN
	CALL Asset_update( OLD.id_asset);
END$$

-- Procedure
DROP PROCEDURE if EXISTS `Asset_update`$$

CREATE PROCEDURE `Asset_update`(IN `idAsset` INT) COMMENT 'Set balance in Asset'
/* Set  */
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE wtype INT;
	DECLARE freeTotal, lockedTotal, frozenTotal, stakedTotal, total DECIMAL(19,9) DEFAULT 0;
  DECLARE freeToken, lockedToken, frozenToken DECIMAL(16,9) DEFAULT 0;

	DECLARE cur CURSOR FOR SELECT `free_token`, `locked_token`, `freeze_token`, `type` FROM `asset_exchange` WHERE `id_asset` = idAsset;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	OPEN cur;
    ins_loop: LOOP
      FETCH cur INTO freeToken, lockedToken, frozenToken, wtype;
      
      if done then
        LEAVE ins_loop;
      end if;
      if (freeToken is null) then SET freeToken = 0; end if;
      if (lockedToken is null) then SET lockedToken = 0; end if;
      if (frozenToken is null) then SET frozenToken = 0; end if;

      if (wtype = 0) then 
        SET freeTotal = freeTotal+(freeToken); 
      else
        SET stakedTotal = stakedTotal+(freeToken);
      end if;
      
      SET lockedToken = lockedToken+(lockedToken);
      SET frozenTotal = frozenTotal+(frozenToken);
      SET total = total+(freeTotal+stakedTotal+lockedToken+frozenTotal);

    end LOOP;
  CLOSE cur;

	UPDATE `asset` SET 
    `free_token` = freeTotal, 
    `locked_token` = lockedToken, 
    `freeze_token` = frozenTotal,
    `staked_token` = stakedTotal,
    `total_token` = total 
  WHERE `id_asset` = idAsset;

END$$

DROP PROCEDURE IF EXISTS `debug_msg`$$

CREATE PROCEDURE debug_msg( msg VARCHAR(255), msg2 VARCHAR(255))
BEGIN
    select msg2, msg AS msg;
END $$

DELIMITER ;