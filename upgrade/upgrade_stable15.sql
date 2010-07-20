-- SENAYAN 3.0 stable 15
-- Senayan SQL Database upgrade script

-- search biblio index table

DROP TABLE IF EXISTS `search_biblio`;
CREATE TABLE IF NOT EXISTS `search_biblio` (
  `biblio_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `edition` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isbn_issn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  `items` text COLLATE utf8_unicode_ci,
  `collection_types` text COLLATE utf8_unicode_ci,
  `call_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `opac_hide` smallint(1) NOT NULL DEFAULT '0',
  `promoted` smallint(1) NOT NULL DEFAULT '0',
  `labels` text COLLATE utf8_unicode_ci,
  `collation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `input_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  UNIQUE KEY `biblio_id` (`biblio_id`),
  KEY `additional_indexes` (`gmd`,`publisher`,`publish_place`,`language`,`classification`,`year`,`opac_hide`,`promoted`,`call_number`,`edition`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `author` (`author`),
  FULLTEXT KEY `topic` (`topic`),
  FULLTEXT KEY `location` (`location`),
  FULLTEXT KEY `items` (`items`),
  FULLTEXT KEY `collection_types` (`collection_types`),
  FULLTEXT KEY `labels` (`labels`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='index table for advance searching technique for SLiMS';

-- member custom fields
CREATE TABLE IF NOT EXISTS `member_custom` (
`member_id` VARCHAR(20) NOT NULL ,
PRIMARY KEY ( `member_id` )
) ENGINE = MYISAM COMMENT = 'one to one relation with real member table';
