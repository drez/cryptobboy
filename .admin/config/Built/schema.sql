
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- authy
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `authy`;

CREATE TABLE `authy`
(
    `id_authy` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `validation_key` VARCHAR(32),
    `username` VARCHAR(32) COMMENT 'Username',
    `fullname` VARCHAR(100) COMMENT 'Fullname',
    `email` VARCHAR(100) NOT NULL COMMENT 'Email',
    `passwd_hash` VARCHAR(32) NOT NULL COMMENT 'Password',
    `expire` DATE DEFAULT '0000-00-00' COMMENT 'Expiration',
    `deactivate` TINYINT DEFAULT 1 COMMENT 'Deactivated',
    `is_root` TINYINT DEFAULT 1 NOT NULL,
    `id_authy_group` INTEGER DEFAULT 1 NOT NULL COMMENT 'Primary group',
    `is_system` TINYINT DEFAULT 1 NOT NULL,
    `rights_all` TEXT COMMENT 'Rights',
    `rights_group` TEXT COMMENT 'Rights group',
    `rights_owner` TEXT COMMENT 'Rights owner',
    `onglet` TEXT,
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_authy`),
    UNIQUE INDEX `authy_U_1` (`username`),
    INDEX `authy_FI_1` (`id_authy_group`),
    INDEX `authy_FI_2` (`id_group_creation`),
    INDEX `authy_FI_3` (`id_creation`),
    INDEX `authy_FI_4` (`id_modification`),
    CONSTRAINT `authy_FK_1`
        FOREIGN KEY (`id_authy_group`)
        REFERENCES `authy_group` (`id_authy_group`)
        ON DELETE CASCADE,
    CONSTRAINT `authy_FK_2`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `authy_FK_3`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `authy_FK_4`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='User';

-- ---------------------------------------------------------------------
-- country
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country`
(
    `id_country` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) COMMENT 'Name',
    `code` VARCHAR(3) COMMENT 'Code',
    `timezone` VARCHAR(20) COMMENT 'Timezone',
    `timezone_code` VARCHAR(50) COMMENT 'Timezone code',
    `priority` INTEGER(10) COMMENT 'Priority',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_country`),
    INDEX `country_FI_1` (`id_group_creation`),
    INDEX `country_FI_2` (`id_creation`),
    INDEX `country_FI_3` (`id_modification`),
    CONSTRAINT `country_FK_1`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `country_FK_2`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `country_FK_3`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Country';

-- ---------------------------------------------------------------------
-- asset
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `asset`;

CREATE TABLE `asset`
(
    `id_asset` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `id_token` INTEGER(11) NOT NULL COMMENT 'Token',
    `free_token` DECIMAL(16, 9) COMMENT 'Free',
    `staked_token` DECIMAL(16, 9) COMMENT 'Staked',
    `total_token` DECIMAL(16, 9) COMMENT 'Total',
    `usd_value` DECIMAL(12, 2) COMMENT 'Value USD',
    `avg_price` DECIMAL(14, 4) COMMENT 'Avg. price',
    `profit` DECIMAL(12, 2) COMMENT 'Profit',
    `locked_token` DECIMAL(16, 9) COMMENT 'Locked',
    `freeze_token` DECIMAL(16, 9) COMMENT 'Frozen',
    `last_sync` DATETIME COMMENT 'Last sync',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_asset`),
    INDEX `asset_FI_1` (`id_token`),
    INDEX `asset_FI_2` (`id_group_creation`),
    INDEX `asset_FI_3` (`id_creation`),
    INDEX `asset_FI_4` (`id_modification`),
    CONSTRAINT `asset_FK_1`
        FOREIGN KEY (`id_token`)
        REFERENCES `token` (`id_token`),
    CONSTRAINT `asset_FK_2`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `asset_FK_3`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `asset_FK_4`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Asset';

-- ---------------------------------------------------------------------
-- asset_exchange
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `asset_exchange`;

CREATE TABLE `asset_exchange`
(
    `id_asset_exchange` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `id_asset` INTEGER(11) NOT NULL,
    `type` TINYINT NOT NULL COMMENT 'Type',
    `id_exchange` INTEGER(11) NOT NULL COMMENT 'Exchange',
    `id_token` INTEGER(11) NOT NULL,
    `free_token` DECIMAL(16, 9) COMMENT 'Free',
    `locked_token` DECIMAL(16, 9) COMMENT 'Locked',
    `freeze_token` DECIMAL(16, 9) COMMENT 'Frozen',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_asset_exchange`),
    INDEX `asset_exchange_FI_1` (`id_asset`),
    INDEX `asset_exchange_FI_2` (`id_exchange`),
    INDEX `asset_exchange_FI_3` (`id_token`),
    INDEX `asset_exchange_FI_4` (`id_group_creation`),
    INDEX `asset_exchange_FI_5` (`id_creation`),
    INDEX `asset_exchange_FI_6` (`id_modification`),
    CONSTRAINT `asset_exchange_FK_1`
        FOREIGN KEY (`id_asset`)
        REFERENCES `asset` (`id_asset`),
    CONSTRAINT `asset_exchange_FK_2`
        FOREIGN KEY (`id_exchange`)
        REFERENCES `exchange` (`id_exchange`),
    CONSTRAINT `asset_exchange_FK_3`
        FOREIGN KEY (`id_token`)
        REFERENCES `token` (`id_token`),
    CONSTRAINT `asset_exchange_FK_4`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `asset_exchange_FK_5`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `asset_exchange_FK_6`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Wallet';

-- ---------------------------------------------------------------------
-- trade
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `trade`;

CREATE TABLE `trade`
(
    `id_trade` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `type` TINYINT NOT NULL COMMENT 'State',
    `id_exchange` INTEGER(11) NOT NULL COMMENT 'Exchange',
    `id_asset` INTEGER(11) NOT NULL,
    `qty` DECIMAL(16, 9) COMMENT 'Qty',
    `id_symbol` INTEGER(11) NOT NULL COMMENT 'Symbol',
    `date` DATETIME COMMENT 'Date',
    `gross_usd` DECIMAL(16, 9) COMMENT 'Price',
    `commission` DECIMAL(16, 9) COMMENT 'Commission',
    `commission_asset` INTEGER(11) COMMENT 'commissionAsset',
    `order_id` BIGINT(10),
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_trade`),
    INDEX `trade_FI_1` (`id_exchange`),
    INDEX `trade_FI_2` (`id_asset`),
    INDEX `trade_FI_3` (`id_symbol`),
    INDEX `trade_FI_4` (`commission_asset`),
    INDEX `trade_FI_5` (`id_group_creation`),
    INDEX `trade_FI_6` (`id_creation`),
    INDEX `trade_FI_7` (`id_modification`),
    CONSTRAINT `trade_FK_1`
        FOREIGN KEY (`id_exchange`)
        REFERENCES `exchange` (`id_exchange`),
    CONSTRAINT `trade_FK_2`
        FOREIGN KEY (`id_asset`)
        REFERENCES `asset` (`id_asset`),
    CONSTRAINT `trade_FK_3`
        FOREIGN KEY (`id_symbol`)
        REFERENCES `symbol` (`id_symbol`),
    CONSTRAINT `trade_FK_4`
        FOREIGN KEY (`commission_asset`)
        REFERENCES `token` (`id_token`),
    CONSTRAINT `trade_FK_5`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `trade_FK_6`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `trade_FK_7`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Trade';

-- ---------------------------------------------------------------------
-- exchange
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `exchange`;

CREATE TABLE `exchange`
(
    `id_exchange` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) COMMENT 'Name',
    `api_key` VARCHAR(1),
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_exchange`),
    INDEX `exchange_FI_1` (`id_group_creation`),
    INDEX `exchange_FI_2` (`id_creation`),
    INDEX `exchange_FI_3` (`id_modification`),
    CONSTRAINT `exchange_FK_1`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `exchange_FK_2`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `exchange_FK_3`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Exchange';

-- ---------------------------------------------------------------------
-- token
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `token`;

CREATE TABLE `token`
(
    `id_token` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) COMMENT 'Name',
    `ticker` VARCHAR(100) COMMENT 'Ticker',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_token`),
    INDEX `token_FI_1` (`id_group_creation`),
    INDEX `token_FI_2` (`id_creation`),
    INDEX `token_FI_3` (`id_modification`),
    CONSTRAINT `token_FK_1`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `token_FK_2`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `token_FK_3`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Token';

-- ---------------------------------------------------------------------
-- symbol
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `symbol`;

CREATE TABLE `symbol`
(
    `id_symbol` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) COMMENT 'Symbol',
    `id_token` INTEGER(11) NOT NULL COMMENT 'Base Ticker',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_symbol`),
    INDEX `symbol_FI_1` (`id_token`),
    INDEX `symbol_FI_2` (`id_group_creation`),
    INDEX `symbol_FI_3` (`id_creation`),
    INDEX `symbol_FI_4` (`id_modification`),
    CONSTRAINT `symbol_FK_1`
        FOREIGN KEY (`id_token`)
        REFERENCES `token` (`id_token`),
    CONSTRAINT `symbol_FK_2`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `symbol_FK_3`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `symbol_FK_4`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Symbol';

-- ---------------------------------------------------------------------
-- import
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `import`;

CREATE TABLE `import`
(
    `id_import` INTEGER(10) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) COMMENT 'Name',
    `items` INTEGER(10) COMMENT 'Items',
    `file` VARCHAR(100) COMMENT 'File',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_import`),
    INDEX `import_FI_1` (`id_group_creation`),
    INDEX `import_FI_2` (`id_creation`),
    INDEX `import_FI_3` (`id_modification`),
    CONSTRAINT `import_FK_1`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `import_FK_2`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `import_FK_3`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Import';

-- ---------------------------------------------------------------------
-- authy_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `authy_group`;

CREATE TABLE `authy_group`
(
    `id_authy_group` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) COMMENT 'Name',
    `desc` VARCHAR(32) COMMENT 'Description',
    `default_group` TINYINT NOT NULL COMMENT 'Default',
    `admin` TINYINT NOT NULL COMMENT 'Admin',
    `rights_all` VARCHAR(1023) COMMENT 'Rights',
    `rights_owner` VARCHAR(1023) COMMENT 'Rights owner',
    `rights_group` VARCHAR(1023) COMMENT 'Rights group',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_authy_group`),
    INDEX `authy_group_FI_1` (`id_group_creation`),
    INDEX `authy_group_FI_2` (`id_creation`),
    INDEX `authy_group_FI_3` (`id_modification`),
    CONSTRAINT `authy_group_FK_1`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `authy_group_FK_2`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `authy_group_FK_3`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Group';

-- ---------------------------------------------------------------------
-- authy_group_x
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `authy_group_x`;

CREATE TABLE `authy_group_x`
(
    `id_authy` INTEGER NOT NULL,
    `id_authy_group` INTEGER NOT NULL COMMENT 'Group',
    PRIMARY KEY (`id_authy`,`id_authy_group`),
    INDEX `authy_group_x_FI_1` (`id_authy_group`),
    CONSTRAINT `authy_group_x_FK_1`
        FOREIGN KEY (`id_authy_group`)
        REFERENCES `authy_group` (`id_authy_group`)
        ON DELETE CASCADE,
    CONSTRAINT `authy_group_x_FK_2`
        FOREIGN KEY (`id_authy`)
        REFERENCES `authy` (`id_authy`)
        ON UPDATE CASCADE
) ENGINE=InnoDB COMMENT='Group';

-- ---------------------------------------------------------------------
-- authy_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `authy_log`;

CREATE TABLE `authy_log`
(
    `id_authy_log` INTEGER NOT NULL AUTO_INCREMENT,
    `id_authy` INTEGER,
    `timestamp` DATETIME COMMENT 'Date',
    `login` VARCHAR(50) NOT NULL COMMENT 'Username',
    `userid` INTEGER,
    `result` VARCHAR(100) NOT NULL,
    `ip` VARCHAR(16) NOT NULL COMMENT 'Ip',
    `count` INTEGER COMMENT 'Count',
    PRIMARY KEY (`id_authy_log`),
    INDEX `authy_log_FI_1` (`id_authy`),
    CONSTRAINT `authy_log_FK_1`
        FOREIGN KEY (`id_authy`)
        REFERENCES `authy` (`id_authy`)
        ON UPDATE CASCADE
) ENGINE=InnoDB COMMENT='Login log';

-- ---------------------------------------------------------------------
-- message
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message`
(
    `id_message` INTEGER NOT NULL AUTO_INCREMENT,
    `label` VARCHAR(100) NOT NULL COMMENT 'Label',
    PRIMARY KEY (`id_message`)
) ENGINE=InnoDB COMMENT='Message';

-- ---------------------------------------------------------------------
-- config
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config`
(
    `id_config` INTEGER NOT NULL AUTO_INCREMENT,
    `category` TINYINT NOT NULL COMMENT 'Category',
    `config` VARCHAR(100) NOT NULL COMMENT 'Setting',
    `value` TEXT(400) COMMENT 'Value',
    `system` TINYINT DEFAULT 0,
    `description` VARCHAR(100) COMMENT 'Description',
    `type` VARCHAR(35),
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_config`),
    INDEX `config_FI_1` (`id_group_creation`),
    INDEX `config_FI_2` (`id_creation`),
    INDEX `config_FI_3` (`id_modification`),
    CONSTRAINT `config_FK_1`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `config_FK_2`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `config_FK_3`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Setting';

-- ---------------------------------------------------------------------
-- api_rbac
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `api_rbac`;

CREATE TABLE `api_rbac`
(
    `id_api_rbac` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `date_creation` DATE NOT NULL COMMENT 'Date',
    `description` TEXT(1023) COMMENT 'Description',
    `model` VARCHAR(200) NOT NULL COMMENT 'Model',
    `action` VARCHAR(200) COMMENT 'Action',
    `body` TEXT(1023) COMMENT 'Body',
    `query` TEXT(1023) COMMENT 'Query',
    `method` TINYINT DEFAULT 0 NOT NULL COMMENT 'Method',
    `scope` TINYINT DEFAULT 0 NOT NULL COMMENT 'Scope',
    `rule` TINYINT DEFAULT 1 NOT NULL COMMENT 'Rule',
    `count` INTEGER DEFAULT 0 NOT NULL COMMENT 'Used count',
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_api_rbac`),
    INDEX `api_rbac_FI_1` (`id_group_creation`),
    INDEX `api_rbac_FI_2` (`id_creation`),
    INDEX `api_rbac_FI_3` (`id_modification`),
    CONSTRAINT `api_rbac_FK_1`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `api_rbac_FK_2`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `api_rbac_FK_3`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='API ACL';

-- ---------------------------------------------------------------------
-- api_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `api_log`;

CREATE TABLE `api_log`
(
    `id_api_log` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `id_api_rbac` INTEGER NOT NULL COMMENT 'Rule',
    `id_authy` INTEGER,
    `time` DATETIME NOT NULL COMMENT 'Time',
    PRIMARY KEY (`id_api_log`),
    INDEX `api_log_FI_1` (`id_api_rbac`),
    INDEX `api_log_FI_2` (`id_authy`),
    CONSTRAINT `api_log_FK_1`
        FOREIGN KEY (`id_api_rbac`)
        REFERENCES `api_rbac` (`id_api_rbac`)
        ON DELETE CASCADE,
    CONSTRAINT `api_log_FK_2`
        FOREIGN KEY (`id_authy`)
        REFERENCES `authy` (`id_authy`)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='API log';

-- ---------------------------------------------------------------------
-- template
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `template`;

CREATE TABLE `template`
(
    `id_template` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL COMMENT 'Name',
    `subject` VARCHAR(200) COMMENT 'Subject',
    `color_1` VARCHAR(10) COMMENT 'Color 1',
    `color_2` VARCHAR(10) COMMENT 'Color 2',
    `color_3` VARCHAR(10) COMMENT 'Color 3',
    `status` TINYINT DEFAULT 0 NOT NULL COMMENT 'Status',
    `body` TEXT(1023) COMMENT 'Body',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_template`),
    INDEX `template_FI_1` (`id_group_creation`),
    INDEX `template_FI_2` (`id_creation`),
    INDEX `template_FI_3` (`id_modification`),
    CONSTRAINT `template_FK_1`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `template_FK_2`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `template_FK_3`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='Template';

-- ---------------------------------------------------------------------
-- template_file
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `template_file`;

CREATE TABLE `template_file`
(
    `id_template_file` INTEGER(11) NOT NULL AUTO_INCREMENT,
    `id_template` INTEGER NOT NULL,
    `name` VARCHAR(100) COMMENT 'Name',
    `file` VARCHAR(500) COMMENT 'File',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_template_file`),
    INDEX `template_file_FI_1` (`id_template`),
    INDEX `template_file_FI_2` (`id_group_creation`),
    INDEX `template_file_FI_3` (`id_creation`),
    INDEX `template_file_FI_4` (`id_modification`),
    CONSTRAINT `template_file_FK_1`
        FOREIGN KEY (`id_template`)
        REFERENCES `template` (`id_template`)
        ON DELETE CASCADE,
    CONSTRAINT `template_file_FK_2`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `template_file_FK_3`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `template_file_FK_4`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB COMMENT='File';

-- ---------------------------------------------------------------------
-- message_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `message_i18n`;

CREATE TABLE `message_i18n`
(
    `id_message` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `text` TEXT(200) COMMENT 'Texte',
    `date_creation` DATETIME,
    `date_modification` DATETIME,
    `id_group_creation` INTEGER,
    `id_creation` INTEGER,
    `id_modification` INTEGER,
    PRIMARY KEY (`id_message`,`locale`),
    INDEX `message_i18n_FI_2` (`id_group_creation`),
    INDEX `message_i18n_FI_3` (`id_creation`),
    INDEX `message_i18n_FI_4` (`id_modification`),
    CONSTRAINT `message_i18n_FK_1`
        FOREIGN KEY (`id_message`)
        REFERENCES `message` (`id_message`)
        ON DELETE CASCADE,
    CONSTRAINT `message_i18n_FK_2`
        FOREIGN KEY (`id_group_creation`)
        REFERENCES `authy_group` (`id_authy_group`),
    CONSTRAINT `message_i18n_FK_3`
        FOREIGN KEY (`id_creation`)
        REFERENCES `authy` (`id_authy`),
    CONSTRAINT `message_i18n_FK_4`
        FOREIGN KEY (`id_modification`)
        REFERENCES `authy` (`id_authy`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
