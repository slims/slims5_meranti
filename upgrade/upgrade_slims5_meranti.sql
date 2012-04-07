ALTER TABLE  `mst_topic` ADD  `classification` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT  'Classification Code' AFTER  `auth_list` ;
ALTER TABLE `biblio` ADD `sor` VARCHAR( 200 ) COLLATE utf8_unicode_ci NULL AFTER `title` ;
ALTER TABLE `biblio` DROP INDEX `references_idx` ,ADD INDEX `references_idx` ( `gmd_id` , `publisher_id` , `language_id` , `publish_place_id`) ;
INSERT INTO `setting` (`setting_id`, `setting_name`, `setting_value`) VALUES (NULL , 'ignore_holidays_fine_calc', 'b:0;');
