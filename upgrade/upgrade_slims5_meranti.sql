ALTER TABLE  `mst_topic` ADD  `classification` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT  'Classification Code' AFTER  `auth_list` ;

CREATE TABLE IF NOT EXISTS `mst_sor` (
  `sor_id` int(11) NOT NULL auto_increment,
  `sor` varchar(255) collate utf8_unicode_ci default NULL,
  `input_date` datetime default NULL,
  `last_update` datetime default NULL,
  PRIMARY KEY  (`sor_id`),
  FULLTEXT KEY `sor_ft_idx` (`sor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

ALTER TABLE `biblio` DROP INDEX `references_idx` ,ADD INDEX `references_idx` ( `gmd_id` , `publisher_id` , `language_id` , `publish_place_id` , `sor_id` ) ;