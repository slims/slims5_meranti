<?php
/**
 *
 * MODS XML to SENAYAN converter
 *
 * Copyright (C) 2010 Hendro Wicaksono (hendrowicaksono@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

/**
 * MODS XML parser for SENAYAN 3
 * @param   string  $str_modsxml
 * @return  array
 **/
function modsXMLsenayan($str_modsxml, $str_xml_type = 'string')
{
    // initiate records array
    $_records = array();

    // load XML
    if ($str_xml_type == 'file') {
        // load from file
        if (file_exists($str_modsxml)) {
            $xml = @simplexml_load_file($str_modsxml);
        } else {
            return 'File '.$str_modsxml.' not found! Please supply full path to MODS XML file';
        }
    } else {
        // load from string
        try {
            $xml = new SimpleXMLElement($str_modsxml);
        } catch (Exception $xmlerr) {
            die($xmlerr->getMessage());
        }
    }

    $record_num = 0;
    // start iterate records
    foreach($xml->mods as $record) {
        # authors
        $data['author_main'] = array();
        $data['author_add'] = array();
        $data['author_corp'] = array();
        $data['author_conf'] = array();

        # title
        $data['title'] = $record->titleInfo->title;

        if (isset($record->titleInfo->subTitle)) {
            $data['title'] .= $record->titleInfo->subTitle;
        }

        # name/author (repeatable)
        if (isset($record->name)) {
            foreach ($record->name as $value) {
                $name_ptype[] = $record->name['type'];
                $name_pauthority[] = $record->name['authority'];
                $name_namePart[] = $record->name->namePart;
                $name_role_roleTerm_ptype[] = $record->name->role->roleTerm['type'];
                $name_role_roleTerm[] = $record->name->role->roleTerm;
                if ($record->name->role->roleTerm == 'Primary Author') {
                    $data['author_main'] = array('name' => $record->name->namePart, 'authority_list' => $record->name['authority']);
                }
            }
        }

        # mods->typeOfResource
        $typeOfResource_pmanuscript = $record->typeOfResource['manuscript'];
        $typeOfResource_pcollection = $record->typeOfResource['collection'];
        $typeOfResource = $record->typeOfResource;

        # mods->genre
        $genre_pauthority = $record->genre['authority'];
        $genre = $record->genre;

        # mods->originInfo
        $originInfo->place->placeTerm_ptype = $record->originInfo->place->placeTerm['type'];
        $originInfo->place->placeTerm = $record->originInfo->place->placeTerm;
        $originInfo->publisher = $record->originInfo->publisher;
        $originInfo->dateIssued = $record->originInfo->dateIssued;
        $originInfo->issuance = $record->originInfo->issuance;
        $originInfo->edition = $record->originInfo->edition;

        # mods->language
        $language->languageTerm_ptype_pcode = $record->language->languageTerm['type']['type'];
        $language->languageTerm_ptype_ptext = $record->language->languageTerm['type']['text'];

        # mods->physicalDescription
        $physicalDescription_form_pauthority = $record->physicalDescription->form['authority'];
        $physicalDescription_form = $record->physicalDescription->form;
        $physicalDescription_extent = $record->physicalDescription->extent;

        # mods->relatedItem
        $relatedItem_ptype = $record->relatedItem['type'];
        $relatedItem_titleInfo_title = $record->relatedItem->titleInfo->title;

        # mods->note
        $note = $record->note;

        # mods->subject
        foreach ($record->subject as $value) {
            $subject_pauthority = $record->subject['authority'];
            $subject_topic = $record->subject->topic;
            $subject_geographic = $record->subject->geographic;
            $subject_name = $record->subject->name;
            $subject_temporal = $record->subject->temporal;
            $subject_genre = $record->subject->genre;
            $subject_occupation = $record->subject->occupation;
        }

        # mods->classification
        $classification = $record->classification;

        # mods->identifier
        $identifier_ptype = $record->identifier['type'];
        $identifier = $record->identifier;

        # mods->location
        $location_physicalLocation = $record->location->physicalLocation;
        $location_shelfLocator = $record->location->shelfLocator;

        # mods->recordInfo
        $recordInfo_recordIdentifier = $record->recordInfo->recordIdentifier;
        $recordInfo_recordCreationDate_pencoding = $record->recordInfo->recordCreationDate['encoding'];
        $recordInfo_recordCreationDate = $record->recordInfo->recordCreationDate;
        $recordInfo_recordChangeDate_pencoding = $record->recordInfo->recordChangeDate['encoding'];
        $recordInfo_recordChangeDate = $record->recordInfo->recordChangeDate;
        $recordInfo_recordOrigin = $record->recordInfo->recordOrigin;

        $data['gmd'] = (string)$gmd;
        $data['gmd'] = str_replace(array('[', ']'), '', trim($data['gmd']));
        $data['edition'] = (string)$edition;
        $data['isbn_issn'] = (string)$isbn_issn;
        $data['publisher'] = (string)$publisher;
        $data['publish_year'] = (integer)$publish_year;
        $data['collation'] = (string)$physical;
        $data['series_title'] = (string)$series;
        $data['call_number'] = (string)$call_number;
        $data['language'] = (string)$language;
        $data['publish_place'] = (string)$publish_place;
        $data['classification'] = (string)$classification;
        $data['notes'] = (string)$notes;
        $data['author_main'] = $main_author;
        $data['authors_add'] = $authors;
        $data['authors_corp'] = $corp_authors;
        $data['authors_conf'] = $conf_authors;
        $data['subjects'] = $topics;
        $data['copies'] = $copies;

        $_records[] = $data;

        #var_dump($record);
        $record_num++;
    }
    return $_records;
}
?>
