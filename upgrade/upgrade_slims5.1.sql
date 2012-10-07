ALTER TABLE `biblio` ADD `subtitle` TEXT COLLATE utf8_unicode_ci NULL AFTER `title` ;
ALTER TABLE `biblio` ADD `volume` VARCHAR( 45 ) COLLATE utf8_unicode_ci NULL AFTER `series_title` ;