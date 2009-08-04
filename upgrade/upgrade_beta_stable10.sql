-- SENAYAN 3.0 stable 10
-- Upgrade script for Beta version of Senayan 3.0 Stable 10
-- Senayan SQL Database upgrade script

ALTER TABLE `mst_author` ADD `auth_list` VARCHAR( 20 ) NULL DEFAULT NULL AFTER `authority_type`;
ALTER TABLE `mst_topic` ADD `topic_type` ENUM( 't', 'g', 'n', 'tm', 'gr', 'oc' ) NOT NULL AFTER `topic`;
ALTER TABLE `mst_topic` ADD `auth_list` VARCHAR( 20 ) NULL DEFAULT NULL AFTER `topic_type`;
ALTER TABLE `files` ADD `file_title` TEXT NOT NULL AFTER `file_id`;
