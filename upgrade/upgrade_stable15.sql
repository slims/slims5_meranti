-- SENAYAN 3.0 stable 15
-- Senayan SQL Database upgrade script

-- search biblio index table
CREATE TABLE IF NOT EXISTS `search_biblio` (
  `biblio_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `author` text COLLATE utf8_unicode_ci,
  `topic` text COLLATE utf8_unicode_ci,
  `gmd` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publisher` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish_place` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classification` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spec_detail_info` text COLLATE utf8_unicode_ci,
  `location` text COLLATE utf8_unicode_ci,
  `year` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `series` text COLLATE utf8_unicode_ci,
  `barcodes` text COLLATE utf8_unicode_ci,
  `collection_types` text COLLATE utf8_unicode_ci,
  UNIQUE KEY `biblio_id` (`biblio_id`),
  KEY `additional_indexes` (`gmd`,`publisher`,`publish_place`,`language`,`classification`,`year`),
  FULLTEXT KEY `fulltext_indexes` (`title`,`series`,`author`,`topic`,`location`,`notes`,`barcodes`,`collection_types`,`spec_detail_info`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='index table for advance searching technique for SLiMS';

-- member custom fields
CREATE TABLE IF NOT EXISTS `member_custom` (
`member_id` VARCHAR(20) NOT NULL ,
PRIMARY KEY ( `member_id` )
) ENGINE = MYISAM COMMENT = 'one to one relation with real member table';