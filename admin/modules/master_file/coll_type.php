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

/* Collection Type Management section */

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
$can_read = utility::havePrivilege('master_file', 'r');
$can_write = utility::havePrivilege('master_file', 'w');

if (!$can_read) {
    die('<div class="errorBox">'._('You don\'t have enough privileges to view this section').'</div>');
}

/* RECORD OPERATION */
if (isset($_POST['saveData'])) {
    $collTypeName = trim(strip_tags($_POST['collTypeName']));
    // check form validity
    if (empty($collTypeName)) {
        utility::jsAlert(_('Collection type name can\'t be empty'));
        exit();
    } else {
        $data['coll_type_name'] = $dbs->escape_string($collTypeName);
        $data['input_date'] = date('Y-m-d');
        $data['last_update'] = date('Y-m-d');

        // create sql op object
        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // remove input date
            unset($data['input_date']);
            // filter update record ID
            $updateRecordID = (integer)$_POST['updateRecordID'];
            // update the data
            $update = $sql_op->update('mst_coll_type', $data, 'coll_type_id='.$updateRecordID);
            if ($update) {
                utility::jsAlert(_('Colllection Type Data Successfully Updated'));
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', parent.getPreviousAJAXurl(), \'post\');</script>';
            } else { utility::jsAlert(_('Colllection Type Data FAILED to Updated. Please Contact System Administrator')."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            $insert = $sql_op->insert('mst_coll_type', $data);
            if ($insert) {
                utility::jsAlert(_('New Colllection Type Data Successfully Saved'));
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'\', \'post\');</script>';
            } else { utility::jsAlert(_('Author Data FAILED to Save. Please Contact System Administrator')."\nDEBUG : ".$sql_op->error); }
            exit();
        }
    }
    exit();
} else if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!($can_read AND $can_write)) {
        die();
    }
    /* DATA DELETION PROCESS */
    $sql_op = new simbio_dbop($dbs);
    $failed_array = array();
    $error_num = 0;
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array((integer)$_POST['itemID']);
    }
    // loop array
    foreach ($_POST['itemID'] as $itemID) {
        $itemID = (integer)$itemID;
        // check if this item data still have an item
        $item_q = $dbs->query('SELECT ct.coll_type_name, COUNT(item_id) FROM item AS i
            LEFT JOIN mst_coll_type AS ct ON i.coll_type_id=ct.coll_type_id
            WHERE i.coll_type_id='.$itemID.' GROUP BY i.coll_type_id');
        $item_d = $item_q->fetch_row();
        if ($item_d[1] < 1) {
            if (!$sql_op->delete('mst_coll_type', "coll_type_id=$itemID")) {
                $error_num++;
            }
        } else {
            $msg = str_replace('{item_name}', $item_d[0], _('Location ({item_name}) still used by {number_items} item(s)')); //mfc
            $msg = str_replace('{number_items}', $item_d[1], $msg);
            $still_have_item[] = $msg;
            $error_num++;
        }
    }

    if ($still_have_item) {
        $undeleted_coll_types = '';
        foreach ($still_have_item as $coll_type) {
            $undeleted_coll_types .= $coll_type."\n";
        }
        utility::jsAlert(_('Below data can not be deleted:').$undeleted_coll_types);
        exit();
    }
    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(_('All Data Successfully Deleted'));
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    } else {
        utility::jsAlert(_('Some or All Data NOT deleted successfully!\nPlease contact system administrator'));
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    }
    exit();
}
/* RECORD OPERATION END */

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner masterFileIcon">
    <?php echo strtoupper(_('Collection Type')); ?> - <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>master_file/coll_type.php?action=detail', 'get');" class="headerText2"><?php echo _('Add New Collection Type'); ?></a>
    &nbsp; <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>master_file/coll_type.php', 'post');" class="headerText2"><?php echo _('Collection Type List'); ?></a>
    <hr />
    <form name="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo _('Search'); ?> :
    <input type="text" name="keywords" size="30" />
    <input type="button" id="doSearch" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>master_file/coll_type.php?' + $('search').serialize(), 'post')" value="<?php echo _('Search'); ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
/* search form end */
/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    if (!($can_read AND $can_write)) {
        die('<div class="errorBox">'._('You don\'t have enough privileges to view this section').'</div>');
    }
    $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
    $rec_q = $dbs->query("SELECT * FROM mst_coll_type WHERE coll_type_id=$itemID");
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'._('Save').'" class="button"';

    // form table attributes
    $form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
    $form->table_content_attr = 'class="alterCell2"';

    // edit mode flag set
    if ($rec_q->num_rows > 0) {
        $form->edit_mode = true;
        // record ID for delete process
        $form->record_id = $itemID;
        // form record title
        $form->record_title = $rec_d['coll_type_name'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'._('Update').'" class="button"';
    }

    /* Form Element(s) */
    // coll_type_name
    $form->addTextField('text', 'collTypeName', _('Collection Type').'*', $rec_d['coll_type_name'], 'style="width: 60%;"');

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox">'._('You are going to edit collection type data').' : <b>'.$rec_d['coll_type_name'].'</b>  <br />'._('Last Update').$rec_d['last_update'].'</div>'; //mfc
    }
    // print out the form object
    echo $form->printOut();
} else {
    /* COLLECTION TYPE LIST */
    // table spec
    $table_spec = 'mst_coll_type AS ct';

    // create datagrid
    $datagrid = new simbio_datagrid();
    if ($can_read AND $can_write) {
        $datagrid->setSQLColumn('ct.coll_type_id', 'ct.coll_type_name AS \''._('Collection Type').'\'', 'ct.last_update AS \''._('Last Update').'\'');
    } else {
        $datagrid->setSQLColumn('ct.coll_type_name AS \''._('Collection Type').'\'', 'ct.last_update AS \''._('Last Update').'\'');
    }
    $datagrid->setSQLorder('coll_type_name ASC');

    // change the record order
    if (isset($_GET['fld']) AND isset($_GET['dir'])) {
        $datagrid->setSQLorder("'".urldecode($_GET['fld'])."' ".$dbs->escape_string($_GET['dir']));
    }

    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
       $keywords = $dbs->escape_string($_GET['keywords']);
       $datagrid->setSQLCriteria("ct.coll_type_name LIKE '%$keywords%'");
    }

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, ($can_read AND $can_write));
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, _('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
}
/* main content end */
?>
