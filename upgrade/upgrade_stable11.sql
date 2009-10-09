-- SENAYAN 3.0 stable 11
-- Senayan SQL Database upgrade script

-- empty settings table
TRUNCATE TABLE `setting`;

-- item status table change
ALTER TABLE `mst_item_status` ADD `no_loan` SMALLINT( 1 ) NOT NULL DEFAULT '0' AFTER `rules`, ADD INDEX ( no_loan );
ALTER TABLE `mst_item_status` ADD `skip_stock_take` SMALLINT( 1 ) NOT NULL DEFAULT '0' AFTER `no_loan`, ADD INDEX ( skip_stock_take );
UPDATE `mst_item_status` SET `no_loan`=1 WHERE `rules` LIKE '%s:1:"1";%';
UPDATE `mst_item_status` SET `skip_stock_take`=1 WHERE `rules` LIKE '%s:1:"2";%';

-- change label field definition
ALTER TABLE `biblio` CHANGE `labels` `labels` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

-- add member password field and other login related fields
ALTER TABLE `member` ADD `mpasswd` CHAR(32) NULL AFTER `is_pending`;
ALTER TABLE `member` ADD `last_login` DATETIME NULL AFTER `mpasswd` ,
ADD `last_login_ip` VARCHAR(20) NULL AFTER `last_login` 
