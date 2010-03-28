-- UCS 1.0 upgrade script
UPDATE `biblio` SET `orig_biblio_id`=REPLACE(`orig_biblio_id`, `node_id`, '');
ALTER TABLE `biblio` CHANGE `orig_biblio_id` `orig_biblio_id` INT NOT NULL;
ALTER TABLE `biblio` ADD UNIQUE `original_node_idx` (`orig_biblio_id`, `node_id`);
ALTER TABLE  `biblio` DROP INDEX `orig_biblio_id`;
