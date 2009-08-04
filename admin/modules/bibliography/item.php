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


/* Item Management section */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging_ajax.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.lang_sys_common_unauthorized.'</div>');
}

$in_pop_up = false;
// check if we are inside pop-up window
if (isset($_GET['inPopUp'])) {
    $in_pop_up = true;
}

/* RECORD OPERATION */
if (isset($_POST['saveData']) AND $can_read AND $can_write) {
    $itemCode = trim(strip_tags($_POST['itemCode']));
    if (empty($itemCode)) {
        utility::jsAlert(lang_mod_biblio_item_alert_item_code);
        exit();
    } else {
        // biblio title
        $title = trim($_POST['biblioTitle']);
        $data['biblio_id'] = $_POST['biblioID'];
        $data['item_code'] = $dbs->escape_string($itemCode);
        $data['call_number'] = trim($dbs->escape_string($_POST['callNumber']));
        // check inventory code
        $inventoryCode = trim($_POST['inventoryCode']);
        if ($inventoryCode) {
            $data['inventory_code'] = $inventoryCode;
        } else {
            $data['inventory_code'] = 'literal{NULL}';
        }

        $data['location_id'] = $_POST['locationID'];
        $data['site'] = trim($dbs->escape_string(strip_tags($_POST['itemSite'])));
        $data['coll_type_id'] = intval($_POST['collTypeID']);
        $data['item_status_id'] = $dbs->escape_string($_POST['itemStatusID']);
        $data['source'] = $_POST['source'];
        $data['order_no'] = trim($dbs->escape_string(strip_tags($_POST['orderNo'])));
        $data['order_date'] = $_POST['ordDate'];
        $data['received_date'] = $_POST['recvDate'];
        $data['supplier_id'] = $_POST['supplierID'];
        $data['invoice'] = $_POST['invoice'];
        $data['invoice_date'] = $_POST['invcDate'];
        $data['price_currency'] = trim($dbs->escape_string(strip_tags($_POST['priceCurrency'])));
        if (!$data['price_currency']) { $data['price_currency'] = 'literal{NULL}'; }
        $data['price'] = preg_replace('@[.,\-a-z ]@i', '', strip_tags($_POST['price']));
        $data['input_date'] = date('Y-m-d H:i:s');
        $data['last_update'] = date('Y-m-d H:i:s');

        // create sql op object
        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // remove input date
            unset($data['input_date']);
            // filter update record ID
            $updateRecordID = (integer)$_POST['updateRecordID'];
            // update the data
            $update = $sql_op->update('item', $data, "item_id=".$updateRecordID);
            if ($update) {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', $_SESSION['realname'].' update item data ('.$data['item_code'].') with title ('.$title.')');
                utility::jsAlert(lang_mod_biblio_item_alert_updated);
                if ($in_pop_up) {
                    echo '<script type="text/javascript">parent.opener.parent.setIframeContent(\'itemIframe\', \''.MODULES_WEB_ROOT_DIR.'bibliography/iframe_item_list.php?biblioID='.$data['biblio_id'].'\');</script>';
                    echo '<script type="text/javascript">parent.window.close();</script>';
                } else {
                    echo '<script type="text/javascript">parent.setContent(\'mainContent\', parent.getPreviousAJAXurl(), \'get\');</script>';
                }
            } else { utility::jsAlert(lang_mod_biblio_item_alert_not_saved."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            $insert = $sql_op->insert('item', $data);
            if ($insert) {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', $_SESSION['realname'].' insert item data ('.$data['item_code'].') with title ('.$title.')');
                utility::jsAlert(lang_mod_biblio_item_alert_new_saved);
                if ($in_pop_up) {
                    echo '<script type="text/javascript">parent.opener.setIframeContent(\'itemIframe\', \''.MODULES_WEB_ROOT_DIR.'bibliography/iframe_item_list.php?biblioID='.$data['biblio_id'].'\');</script>';
                    echo '<script type="text/javascript">parent.window.close();</script>';
                } else {
                    echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'\', \'post\');</script>';
                }
            } else { utility::jsAlert(lang_mod_biblio_item_alert_not_saved."\nDEBUG : ".$sql_op->error); }
            exit();
        }
    }
    exit();
} else if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!($can_read AND $can_write)) {
        die();
    }
    /* DATA DELETION PROCESS */
    // create sql op object
    $sql_op = new simbio_dbop($dbs);
    $failed_array = array();
    $error_num = 0;
    $still_on_loan = array();
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array((integer)$_POST['itemID']);
    }
    // loop array
    foreach ($_POST['itemID'] as $itemID) {
        $itemID = (integer)$itemID;
        // check if the item still on loan
        $loan_q = $dbs->query('SELECT i.item_code, b.title, COUNT(l.loan_id) FROM item AS i
            LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
            LEFT JOIN loan AS l ON (i.item_code=l.item_code AND l.is_lent=1 AND l.is_return=0)
            WHERE i.item_id='.$itemID.' GROUP BY i.item_code');
        $loan_d = $loan_q->fetch_row();
        // if there is no loan
        if ($loan_d[2] < 1) {
            if (!$sql_op->delete('item', 'item_id='.$itemID)) {
                $error_num++;
            } else {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', $_SESSION['realname'].' DELETE item data ('.$loan_d[0].') with title ('.$loan_d[1].')');
            }
        } else {
            $still_on_loan[] = $loan_d[0].' - '.$loan_d[1];
            $error_num++;
        }
    }

    if ($still_on_loan) {
        $items = '';
        foreach ($still_on_loan as $item) {
            $items .= $item."\n";
        }
        utility::jsAlert(lang_mod_biblio_item_alert_delete_fail_on_loan." : \n".$items);
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
        exit();
    }
    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(lang_mod_biblio_item_alert_remove_success);
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    } else {
        utility::jsAlert(lang_mod_biblio_item_alert_remove_failed);
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    }
    exit();
}
/* RECORD OPERATION END */

if (!$in_pop_up) {
/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner itemIcon">
    <?php echo strtoupper(lang_mod_biblio_item); ?>
    <hr />
    <form name="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo lang_sys_common_form_search; ?> :
    <input type="text" name="keywords" id="keywords" size="30" />
    <input type="button" id="doSearch" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/item.php?' + $('search').serialize(), 'post')" value="<?php echo lang_sys_common_form_search; ?>" class="button" />
    </form>
</div>
</fieldset>
<script type="text/javascript">
// focus member ID text field
$('keywords').focus();
</script>
<?php
/* search form end */
}
/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    if (!($can_read AND $can_write)) {
        die('<div class="errorBox">'.lang_sys_common_unauthorized.'</div>');
    }
    /* RECORD FORM */
    // try query
    $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
    $rec_q = $dbs->query('SELECT item.*, b.biblio_id, b.title, s.supplier_name
        FROM item
        LEFT JOIN biblio AS b ON item.biblio_id=b.biblio_id
        LEFT JOIN mst_supplier AS s ON item.supplier_id=s.supplier_id
        WHERE item_id='.$itemID);
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.lang_sys_common_form_save.'" class="button"';
    // form table attributes
    $form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
    $form->table_content_attr = 'class="alterCell2"';

    // edit mode flag set
    if ($rec_q->num_rows > 0) {
        $form->edit_mode = true;
        // record ID for delete process
        if (!$in_pop_up) {
            $form->record_id = $itemID;
        } else {
            $form->addHidden('updateRecordID', $itemID);
            $form->back_button = false;
        }
        // form record title
        $form->record_title = $rec_d['title'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.lang_sys_common_form_update.'" class="button"';
        // default biblio title and biblio ID
        $b_title = $rec_d['title'];
        $b_id = $rec_d['biblio_id'];
        if (trim($rec_d['call_number']) == '') {
            $biblio_q = $dbs->query('SELECT call_number FROM biblio WHERE biblio_id='.$rec_d['biblio_id']);
            $biblio_d = $biblio_q->fetch_assoc();
            $rec_d['call_number'] = $biblio_d['call_number'];
        }
    } else {
        // get biblio title and biblio ID from database if we are not on edit mode
        $biblioID = 0;
        if (isset($_GET['biblioID'])) {
            $biblioID = (integer)$_GET['biblioID'];
        }
        $biblio_q = $dbs->query('SELECT biblio_id, title, call_number FROM biblio WHERE biblio_id='.$biblioID);
        $biblio_d = $biblio_q->fetch_assoc();
        $b_title = $biblio_d['title'];
        $b_id = $biblio_d['biblio_id'];
        $def_call_number = $biblio_d['call_number'];
    }

    /* Form Element(s) */
    // title
    if (!$in_pop_up) {
        $str_input = $b_title;
        $str_input .= '<div class="makeHidden"><a title="Edit Bibliographic Data" style="font-weight: bold; color: #ff9900;" href="javascript: openWin(\''.MODULES_WEB_ROOT_DIR.'bibliography/pop_biblio.php?inPopUp=true&action=detail&itemID='.$rec_d['biblio_id'].'&itemCollID='.$rec_d['item_id'].'\', \'popBiblio\', 600, 400, true)">Edit Biblographic data</a></div>';
    } else { $str_input = $b_title; }
    $form->addAnything(lang_mod_biblio_item_field_title, $str_input);
    $form->addHidden('biblioTitle', $b_title);
    $form->addHidden('biblioID', $b_id);
    // item code
    $str_input = simbio_form_element::textField('text', 'itemCode', $rec_d['item_code'], 'onblur="ajaxCheckID(\''.SENAYAN_WEB_ROOT_DIR.'admin/AJAX_check_id.php\', \'item\', \'item_code\', \'msgBox\', \'itemCode\')" style="width: 40%;"');
    $str_input .= ' &nbsp; <span id="msgBox">&nbsp;</span>';
    $form->addAnything(lang_mod_biblio_item_field_itemcode, $str_input);
    // call number
    $form->addTextField('text', 'callNumber', lang_mod_biblio_field_call_number, isset($rec_d['call_number'])?$rec_d['call_number']:$def_call_number, 'style="width: 40%;"');
    // inventory code
    $form->addTextField('text', 'inventoryCode', lang_mod_biblio_item_field_inventory, $rec_d['inventory_code'], 'style="width: 100%;"');
    // item location
        // get location data related to this record from database
        $location_q = $dbs->query("SELECT location_id, location_name FROM mst_location");
        $location_options = array();
        while ($location_d = $location_q->fetch_row()) {
            $location_options[] = array($location_d[0], $location_d[1]);
        }
    $form->addSelectList('locationID', lang_mod_biblio_item_field_location, $location_options, $rec_d['location_id']);
    // item site
    $form->addTextField('text', 'itemSite', lang_mod_biblio_item_field_site, $rec_d['site'], 'style="width: 40%;"');
    // collection type
        // get collection type data related to this record from database
        $coll_type_q = $dbs->query("SELECT coll_type_id, coll_type_name FROM mst_coll_type");
        $coll_type_options = array();
        while ($coll_type_d = $coll_type_q->fetch_row()) {
            $coll_type_options[] = array($coll_type_d[0], $coll_type_d[1]);
        }
    $form->addSelectList('collTypeID', lang_mod_biblio_item_field_ctype, $coll_type_options, $rec_d['coll_type_id']);
    // item status
        // get item status data from database
        $item_status_q = $dbs->query("SELECT item_status_id, item_status_name FROM mst_item_status");
        $item_status_options[] = array('0', 'Available');
        while ($item_status_d = $item_status_q->fetch_row()) {
            $item_status_options[] = array($item_status_d[0], $item_status_d[1]);
        }
    $form->addSelectList('itemStatusID', lang_mod_biblio_item_field_item_status, $item_status_options, $rec_d['item_status_id']);
    // order number
    $form->addTextField('text', 'orderNo', lang_mod_biblio_item_field_order_number, $rec_d['order_no'], 'style="width: 40%;"');
    // order date
    $form->addDateField('ordDate', lang_mod_biblio_item_field_order_date, $rec_d['order_date']?$rec_d['order_date']:date('Y-m-d'));
    // received date
    $form->addDateField('recvDate', lang_mod_biblio_item_field_received_date, $rec_d['received_date']?$rec_d['received_date']:date('Y-m-d'));
    // item supplier
        // get item status data from database
        $supplier_q = $dbs->query("SELECT supplier_id, supplier_name FROM mst_supplier");
        $supplier_options[] = array('0', 'None');
        while ($supplier_d = $supplier_q->fetch_row()) {
            $supplier_options[] = array($supplier_d[0], $supplier_d[1]);
        }
    $form->addSelectList('supplierID', lang_mod_biblio_item_field_supplier, $supplier_options, $rec_d['supplier_id']);
    // item source
        $source_options[] = array('1', 'Buy');
        $source_options[] = array('2', 'Prize/Grant');
    $form->addRadio('source', 'Item Source', $source_options, !empty($rec_d['source'])?$rec_d['source']:'1');
    // item invoice
    $form->addTextField('text', 'invoice', lang_mod_biblio_item_field_invoice, $rec_d['invoice'], 'style="width: 100%;"');
    // invoice date
    $form->addDateField('invcDate', lang_mod_biblio_item_field_invoice_date, $rec_d['invoice_date']?$rec_d['invoice_date']:date('Y-m-d'));
    // price
    $str_input = simbio_form_element::textField('text', 'price', !empty($rec_d['price'])?$rec_d['price']:'0', 'style="width: 40%;"');
    $str_input .= simbio_form_element::selectList('priceCurrency', $sysconf['currencies'], $rec_d['price_currency']);;
    $form->addAnything(lang_mod_biblio_item_field_price, $str_input);

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox">'.lang_mod_biblio_item_common_edit_message.': <b>'.$rec_d['title'].'</b> '
            .'<br />'.lang_mod_biblio_item_common_last_update.' '.$rec_d['last_update'];
        echo '</div>'."\n";
    }
    // print out the form object
    echo $form->printOut();
} else {
    /* ITEM LIST */
    // table spec
    $table_spec = 'item AS i
        LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
        LEFT JOIN mst_location AS loc ON i.location_id=loc.location_id
        LEFT JOIN mst_coll_type AS ct ON i.coll_type_id=ct.coll_type_id';

    // create datagrid
    $datagrid = new simbio_datagrid();
    if ($can_write) {
        $datagrid->setSQLColumn('i.item_id',
            'i.item_code AS \'Code\'',
            'b.title AS \'Title\'',
            'ct.coll_type_name AS \'Type\'',
            'loc.location_name AS \'Location\'',
            'b.classification AS \'Class\'',
            'i.last_update AS \'Last Update\'');
    } else {
        $datagrid->setSQLColumn('i.item_code AS \'Item Code\'',
            'b.title AS \'Title\'',
            'ct.coll_type_name AS \'Type\'',
            'loc.location_name AS \'Location\'',
            'b.classification AS \'Classification\'',
            'i.last_update AS \'Last Update\'');
    }

    $datagrid->setSQLorder("i.last_update DESC");

    $criteria = 'item_id IS NOT NULL';
    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $keyword = $dbs->escape_string(trim($_GET['keywords']));
        $words = explode(' ', $keyword);
        if (count($words) > 1) {
            $concat_sql = ' (';
            foreach ($words as $word) {
                $concat_sql .= " (b.title LIKE '%$word%' OR i.item_code LIKE '%$word%') AND";
            }
            // remove the last AND
            $concat_sql = substr_replace($concat_sql, '', -3);
            $concat_sql .= ') ';
            $criteria = $concat_sql;
        } else {
            $criteria = "b.title LIKE '%$keyword%' OR i.item_code LIKE '%$keyword%'";
        }
    }
    $datagrid->setSQLCriteria($criteria);

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, ($can_read AND $can_write));
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, lang_sys_common_search_result_info);
        echo '<div class="infoBox">'.$msg.' : '.$_GET['keywords'].'</div>';
    }

    echo $datagrid_result;
}
/* main content end */
?>
