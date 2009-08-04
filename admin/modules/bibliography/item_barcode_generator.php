<?php
/**
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
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


/* Item barcode print */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging_ajax.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');

if (!$can_read) {
    die('<div class="errorBox">'.lang_sys_common_unauthorized.'</div>');
}

$max_print = 50;

/* RECORD OPERATION */
if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!$can_read) {
        die();
    }
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array((integer)$_POST['itemID']);
    }
    // loop array
    if (isset($_SESSION['barcodes'])) {
        $print_count = count($_SESSION['barcodes']);
    } else {
        $print_count = 0;
    }
    // barcode size
    $size = 2;
    // create AJAX request
    echo '<script type="text/javascript" src="'.JS_WEB_ROOT_DIR.'prototype.js"></script>';
    echo '<script type="text/javascript">';
    // loop array
    foreach ($_POST['itemID'] as $itemID) {
        if ($print_count == $max_print) {
            $limit_reach = true;
            break;
        }
        if (isset($_SESSION['barcodes'][$itemID])) {
            continue;
        }
        if (!empty($itemID)) {
            $barcode_text = trim($itemID);
            /* replace space */
            $barcode_text = str_replace(array(' ', '/', '\/'), '_', $barcode_text);
            /* replace invalid characters */
            $barcode_text = str_replace(array(':', ',', '*', '@'), '', $barcode_text);
            // send ajax request
            echo 'new Ajax.Request(\''.SENAYAN_WEB_ROOT_DIR.'lib/phpbarcode/barcode.php?code='.$itemID.'&encoding='.$sysconf['barcode_encoding'].'&scale='.$size.'&mode=png\', { method: \'get\', onFailure: function(sendAlert) { alert(\'Error creating barcode!\'); } });'."\n";
            // add to sessions
            $_SESSION['barcodes'][$itemID] = $itemID;
            $print_count++;
        }
    }
    echo '</script>';
    sleep(2);
    if (isset($limit_reach)) {
        $msg = str_replace('{max_print}', $max_print, lang_mod_biblio_alert_print_no_add_queue);
        utility::jsAlert($msg);
    } else {
        // update print queue count object
        echo '<script type="text/javascript">parent.$(\'queueCount\').update(\''.$print_count.'\');</script>';
        utility::jsAlert(lang_mod_biblio_alert_print_add_ok);
    }
    exit();
}

// clean print queue
if (isset($_GET['action']) AND $_GET['action'] == 'clear') {
    // update print queue count object
    echo '<script type="text/javascript">parent.$(\'queueCount\').update(\'0\');</script>';
    utility::jsAlert(lang_mod_biblio_common_print_cleared);
    unset($_SESSION['barcodes']);
    exit();
}

// barcode pdf download
if (isset($_GET['action']) AND $_GET['action'] == 'print') {
    // check if label session array is available
    if (!isset($_SESSION['barcodes'])) {
        utility::jsAlert(lang_mod_biblio_common_print_no_data);
        die();
    }
    if (count($_SESSION['barcodes']) < 1) {
        utility::jsAlert(lang_mod_biblio_common_print_no_data);
        die();
    }

    // concat all ID together
    $item_ids = '';
    foreach ($_SESSION['barcodes'] as $id) {
        $item_ids .= '\''.$id.'\',';
    }
    // strip the last comma
    $item_ids = substr_replace($item_ids, '', -1);
    // send query to database
    $item_q = $dbs->query('SELECT b.title, i.item_code FROM item AS i
        LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
        WHERE i.item_code IN('.$item_ids.')');
    $item_data_array = array();
    while ($item_d = $item_q->fetch_row()) {
        if ($item_d[0]) {
            $item_data_array[] = $item_d;
        }
    }

    // include printed settings configuration file
    require SENAYAN_BASE_DIR.'admin'.DIRECTORY_SEPARATOR.'admin_template'.DIRECTORY_SEPARATOR.'printed_settings.inc.php';
    // check for custom template settings
    $custom_settings = SENAYAN_BASE_DIR.'admin'.DIRECTORY_SEPARATOR.$sysconf['admin_template']['dir'].DIRECTORY_SEPARATOR.$sysconf['template']['theme'].DIRECTORY_SEPARATOR.'printed_settings.inc.php';
    if (file_exists($custom_settings)) {
        include $custom_settings;
    }
    // chunk barcode array
    $chunked_barcode_arrays = array_chunk($item_data_array, $barcode_items_per_row);
    // create html ouput
    $html_str = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
    $html_str .= '<html xmlns="http://www.w3.org/1999/xhtml"><head><title>Item Barcode Label Print Result</title>'."\n";
    $html_str .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n";
    $html_str .= '<style type="text/css">'."\n";
    $html_str .= 'body { padding: 0; margin: 1cm; font-family: '.$barcode_fonts.' }'."\n";
    $html_str .= '.labelStyle { width: '.$barcode_box_width.'cm; height: '.$barcode_box_height.'cm; text-align: center; margin: '.$barcode_items_margin.'cm; border: 1px solid #000000;}'."\n";
    $html_str .= '.labelHeaderStyle { background-color: #CCCCCC; font-weight: bold; padding: 5px; margin-bottom: 5px; }'."\n";
    $html_str .= '</style>'."\n";
    $html_str .= '</head>'."\n";
    $html_str .= '<body>'."\n";
    $html_str .= '<table style="margin: 0; padding: 0;" cellspacing="0" cellpadding="0">'."\n";
    // loop the chunked arrays to row
    foreach ($chunked_barcode_arrays as $barcode_rows) {
        $html_str .= '<tr>'."\n";
        foreach ($barcode_rows as $barcode) {
            $html_str .= '<td valign="top">';
            $html_str .= '<div class="labelStyle">';
            if ($barcode_include_header_text) { $html_str .= '<div class="labelHeaderStyle">'.($barcode_header_text?$barcode_header_text:$sysconf['library_name']).'</div>'; }
            // document title
            $html_str .= '<div style="font-size: 7pt;">';
            if ($barcode_cut_title) {
                $html_str .= substr($barcode[0], 0, $barcode_cut_title).'...';
            } else { $html_str .= $barcode[0]; }
            $html_str .= '</div>';
            $html_str .= '<img src="'.SENAYAN_WEB_ROOT_DIR.IMAGES_DIR.'/barcodes/'.str_replace(array(' '), '_', $barcode[1]).'.png" style="width: '.$barcode_scale.'%;" border="0" />';
            $html_str .= '</div>';
            $html_str .= '</td>';
        }
        $html_str .= '<tr>'."\n";
    }
    $html_str .= '</table>'."\n";
    $html_str .= '<script type="text/javascript">self.print();</script>'."\n";
    $html_str .= '</body></html>'."\n";
    // unset the session
    unset($_SESSION['barcodes']);
    // write to file
    $file_write = @file_put_contents(FILES_UPLOAD_DIR.'item_barcode_gen_print_result.html', $html_str);
    if ($file_write) {
        // update print queue count object
        echo '<script type="text/javascript">parent.$(\'queueCount\').update(\'0\');</script>';
        // open result in window
        echo '<script type="text/javascript">parent.openWin(\''.SENAYAN_WEB_ROOT_DIR.FILES_DIR.'/item_barcode_gen_print_result.html\', \'popItemBarcodeGen\', 800, 500, true)</script>';
    } else { utility::jsAlert('ERROR! Item barcodes failed to generate, possibly because '.SENAYAN_BASE_DIR.FILES_DIR.' directory is not writable'); }
    exit();
}

?>
<fieldset class="menuBox">
<div class="menuBoxInner printIcon">
    <?php echo lang_mod_biblio_tools_item_barcode; ?> - <a target="blindSubmit" href="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/item_barcode_generator.php?action=print" class="headerText2"><?php echo lang_mod_biblio_tools_item_barcode_print_select;?></a>
    &nbsp; <a href="#" onclick="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/item_barcode_generator.php?action=clear" class="headerText2" style="color: #FF0000;"><?php echo lang_mod_biblio_tools_item_barcode_clear; ?></a>
    <hr />
    <form name="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo lang_sys_common_form_search_field; ?> :
    <input type="text" name="keywords" size="30" />
    <input type="button" id="doSearch" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/item_barcode_generator.php?' + $('search').serialize(), 'post')" value="<?php echo lang_sys_common_form_search; ?>" class="button" />
    </form>
    <div style="margin-top: 3px;">
    <?php
    echo 'Maximum <font style="color: #FF0000">'.$max_print.'</font> barcodes can be printed at once. Currently there is ';
    if (isset($_SESSION['barcodes'])) {
        echo '<font id="queueCount" style="color: #FF0000">'.count($_SESSION['barcodes']).'</font>';
    } else { echo '<font id="queueCount" style="color: #FF0000">0</font>'; }
    echo ' in queue waiting to be printed.';
    ?>
    </div>
</div>
</fieldset>
<?php
/* search form end */
/* ITEM LIST */
// table spec
$table_spec = 'item AS i
    LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id';
// create datagrid
$datagrid = new simbio_datagrid();
$datagrid->setSQLColumn('i.item_code',
    'i.item_code AS \'Item Code\'',
    'b.title AS \'Title\'');
$datagrid->setSQLorder("i.last_update DESC");
// is there any search
if (isset($_GET['keywords']) AND $_GET['keywords']) {
    $keyword = $dbs->escape_string(trim($_GET['keywords']));
    $words = explode(' ', $keyword);
    if (count($words) > 1) {
        $concat_sql = ' (';
        foreach ($words as $word) {
            $concat_sql .= " (b.title LIKE '%$word%' OR i.item_code LIKE '%$word%'";
        }
        // remove the last AND
        $concat_sql = substr_replace($concat_sql, '', -3);
        $concat_sql .= ') ';
        $datagrid->setSQLCriteria($concat_sql);
    } else {
        $datagrid->setSQLCriteria("b.title LIKE '%$keyword%' OR i.item_code LIKE '%$keyword%' OR b.classification LIKE '%$keyword%'");
    }
}
// set table and table header attributes
$datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
// edit and checkbox property
$datagrid->edit_property = false;
$datagrid->chbox_property = array('itemID', 'Add');
$datagrid->chbox_action_button = lang_mod_biblio_common_form_print_queue;
$datagrid->chbox_confirm_msg = lang_mod_biblio_common_print_queue_confirm;
$datagrid->column_width = array('10%', '85%');
// set checkbox action URL
$datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
// put the result into variables
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, $can_read);
if (isset($_GET['keywords']) AND $_GET['keywords']) {
    $msg = str_replace('{result->num_rows}', $datagrid->num_rows, lang_sys_common_search_result_info);
    echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
}
echo $datagrid_result;
/* main content end */
?>
