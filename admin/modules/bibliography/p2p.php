<?php
/**
 * Copyright (C) 2009 Arie Nugraha (dicarve@yahoo.com)
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

/* Peer-to-Peer Web Services section */

// start the session
require '../../../sysconfig.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You are not authorized to view this section').'</div>');
}

$p2pserver = 'http://localhost/senayan3-stable14';


/* RECORD OPERATION */

if (isset($_POST['saveZ']) AND isset($_POST['p2precord'])) {
#if (isset($_POST['saveZ'])) {
    $recordID = $_POST['p2precord'];

    foreach ($_POST['p2precord'] as $key => $value) {
        #echo $key.' --> '.$value.'<br />';
        $xml = simplexml_load_file($p2pserver."/index.php?p=show_detail&inXML=true&id=".$value);
        #echo $p2pserver."/index.php?p=show_detail&inXML=true&id=".$value;
        if ($xml) {
            foreach($xml->mods as $record) {
                # mods->titleInfo
                $titleInfo_title = $record->titleInfo->title;
                $titleInfo_subTitle = $record->titleInfo->subTitle;
            
                # mods->name (repeatable)
                foreach ($record->name as $value) {
                    $name_ptype[] = $record->name['type'];
                    $name_pauthority[] = $record->name['authority'];
                    $name_namePart[] = $record->name->namePart;
                    $name_role_roleTerm_ptype[] = $record->name->role->roleTerm['type'];
                    $name_role_roleTerm[] = $record->name->role->roleTerm;
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
                $identifier  = $record->identifier;
            
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

                #var_dump($record);
                echo $typeOfResource_collection;
            }
        }
    }
    exit;
}

/* RECORD OPERATION END */


/* SEARCH OPERATION */
if (isset($_GET['keywords']) AND $can_read)  {
    $keywords = urlencode($_GET['keywords']);
    #$p2pquery = $p2pserver.'index.php?resultXML=true&keywords='.$_GET['keywords'];
    $xml = simplexml_load_file($p2pserver."/index.php?resultXML=true&search=Search&keywords=".$keywords);

    # debugging tools
    #echo $p2pserver."/index.php?resultXML=true&keywords=".$keywords;
    #echo '<br />';

    if ($xml) {
        echo '<div class="infoBox">Found '.$xml->modsResultNum.' records from Other Server, only '.$xml->modsResultShowed.' listed.</div>';
        echo '<form method="post" action="'.MODULES_WEB_ROOT_DIR.'bibliography/p2p.php" target="blindSubmit">';
        echo '<table align="center" id="dataList" cellpadding="5" cellspacing="0">';
        echo '<tr>';
        echo '<td colspan="3"><input type="submit" name="saveZ" value="Save P2P Records to Database" /></td>';
        echo '</tr>';
        $row = 1;
        foreach($xml->mods as $record) {
            $row_class = ($row%2 == 0)?'alterCell':'alterCell2';
            echo '<tr>';
            echo '<td width="1%" class="'.$row_class.'"><input type="checkbox" name="p2precord['.$record['ID'].']" value="'.$record['ID'].'" />';
            echo '<strong>';
            echo $record->titleInfo->title.' ';
            $record->titleInfo->subTitle = trim($record->titleInfo->subTitle);
            if (isset($record->titleInfo->subTitle)) {
                echo $record->titleInfo->subTitle."<br />\n";
            }
            echo '</strong>';
            echo '<div><i>';
            foreach ($record->name as $name) {
                echo $name->namePart;
            }
            echo '</i></div></td></tr>';
            $row++;
        }
        echo '</table>';
        echo '</form>';
    }
    exit();
}
/* SEARCH OPERATION END */

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner biblioIcon">
    P2P Service
    <hr />
    <form name="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" id="keywords" size="30" />
    <input type="button" id="doSearch" onclick="setContent('searchResult', '<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/p2p.php?' + $('search').serialize(), 'get')" value="<?php echo __('Search'); ?>" class="button" />
    </form>
    <div><?php echo __('* Please make sure you have a working Internet connection.'); ?></div>
</div>
</fieldset>
<div id="searchResult">&nbsp;</div>
