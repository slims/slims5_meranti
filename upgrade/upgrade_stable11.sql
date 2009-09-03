-- SENAYAN 3.0 stable 11
-- Senayan SQL Database upgrade script

TRUNCATE TABLE `setting`;
ALTER TABLE `biblio` CHANGE `labels` `labels` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
