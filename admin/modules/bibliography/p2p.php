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
require LIB_DIR.'modsxmlsenayan.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You are not authorized to view this section').'</div>');
}

/* RECORD OPERATION */
if (isset($_POST['saveResults']) && isset($_POST['p2precord']) && isset($_POST['p2pserver_save'])) {
    $p2pserver = trim($_POST['p2pserver_save']);
    foreach ($_POST['p2precord'] as $key => $value) {
        #echo $key.' --> '.$value.'<br />';
        $xml = @simplexml_load_file($p2pserver."/index.php?p=show_detail&inXML=true&id=".$value);
        #echo $p2pserver."/index.php?p=show_detail&inXML=true&id=".$value;
        if ($xml) {

        } else {
            echo '<div class="errorBox">'.__('Sorry, no result found from '.$p2pserver).'</div>';
        }
    }
    exit;
}

/* RECORD OPERATION END */


/* SEARCH OPERATION */
if (isset($_GET['keywords']) && $can_read && isset($_GET['p2pserver']))  {
    # get server information
    $serverid = (integer)$_GET['p2pserver'];
    $p2pserver = $sysconf['p2pserver'][$serverid]['uri'];
    $p2pserver_name = $sysconf['p2pserver'][$serverid]['name'];
    # get keywords
    $keywords = urlencode($_GET['keywords']);
    # $p2pquery = $p2pserver.'index.php?resultXML=true&keywords='.$_GET['keywords'];
    $xml = @simplexml_load_file($p2pserver."/index.php?resultXML=true&search=Search&keywords=".$keywords);

    # debugging tools
    # echo $p2pserver."/index.php?resultXML=true&keywords=".$keywords;
    # echo '<br />';

    if ($xml) {
        echo '<div class="infoBox">Found '.$xml->modsResultNum.' records from <strong>'.$p2pserver_name.'</strong> Server</div>';
        echo '<form method="post" class="notAJAX" action="'.MODULES_WEB_ROOT_DIR.'bibliography/p2p.php" target="blindSubmit">';
        echo '<table align="center" id="dataList" cellpadding="5" cellspacing="0">';
        echo '<tr><td colspan="3"><input type="submit" name="saveResults" value="Save P2P Records to Database" /></td></tr>';
        $row = 1;
        foreach($xml->mods as $record) {
            $row_class = ($row%2 == 0)?'alterCell':'alterCell2';
            echo '<tr>';
            echo '<td width="2%" class="'.$row_class.'"><input type="checkbox" name="p2precord['.$record['ID'].']" value="'.$record['ID'].'" /></td>';
            echo '<td width="98%" class="'.$row_class.'"><strong>';
            echo $record->titleInfo->title;
            if (isset($record->titleInfo->subTitle)) { echo ' '.trim($record->titleInfo->subTitle)."\n"; }
            echo '</strong>';
            echo '<div><i>';
            $buffer_authors = '';
            foreach ($record->name as $name) { $buffer_authors .= $name->namePart.' - '; }
            echo substr_replace($buffer_authors, '', -3);
            echo '</i></div>';
            echo '</td>';
            echo '</tr>';
            $row++;
        }
        echo '</table>'."\n";
        echo '<input type="hidden" name="p2pserver_save" value="'.$p2pserver.'" />';
        echo '</form>';
    } else {
        echo '<div class="errorBox">'.__('Sorry, no result found from '.$p2pserver).'</div>';
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
    <form name="search" class="notAJAX" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" id="keywords" size="30" />
    Server: <select name="p2pserver" style="width: 20%;"><?php foreach ($sysconf['p2pserver'] as $serverid => $p2pserver) { echo '<option value="'.$serverid.'">'.$p2pserver['name'].'</option>';  } ?></select>
    <input type="button" id="doSearch" onclick="setContent('searchResult', '<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/p2p.php?' + $('search').serialize(), 'get')" value="<?php echo __('Search'); ?>" class="button" />
    </form>
    <div><?php echo __('* Please make sure you have a working Internet connection.'); ?></div>
</div>
</fieldset>
<div id="searchResult">&nbsp;</div>
