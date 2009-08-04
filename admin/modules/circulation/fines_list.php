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

/* Fines Management section */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';

if (!isset($_SESSION['memberID'])) { die(); }

require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// page title
$page_title = 'Member Loan List';

/* RECORD OPERATION */
if (isset($_POST['saveData'])) {
    $debet = preg_replace('@[.,\-a-z ]@i', '', $_POST['debet']);
    $credit = preg_replace('@[.,\-a-z ]@i', '', $_POST['credit']);
    // check form validity
    if (empty($_POST['finesDesc']) OR empty($debet)) {
        utility::jsAlert(''.lang_mod_circ_common_fines_alert_01.'');
    } else if ($credit > $debet) {
        utility::jsAlert(''.lang_mod_circ_common_fines_alert_02.'');
    } else {
        $data['member_id'] = $_SESSION['memberID'];
        $data['fines_date'] = $_POST['finesYear'].'-'.$_POST['finesMonth'].'-'.$_POST['finesDate'];
        $data['description'] = trim($dbs->escape_string(strip_tags($_POST['finesDesc'])));
        $data['debet'] = $debet;
        $data['credit'] = $credit;

        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // remove input date
            unset($data['input_date']);
            // filter update record ID
            $updateRecordID = (integer)$_POST['updateRecordID'];
            // update the data
            $update = $sql_op->update('fines', $data, 'fines_id='.$updateRecordID);
            if ($update) {
                utility::jsAlert(lang_mod_circ_fines_alert_updated);
                echo '<script type="text/javascript">self.location.href = \'fines_list.php\';</script>';
            } else { utility::jsAlert(lang_mod_circ_fines_alert_not_updated."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            $insert = $sql_op->insert('fines', $data);
            if ($insert) {
                utility::jsAlert(lang_mod_circ_fines_alert_new_added);
                echo '<script type="text/javascript">self.location.href = \'fines_list.php\';</script>';
            } else { utility::jsAlert(lang_mod_circ_fines_alert_fail_to_save."\n".$sql_op->error); }
            exit();
        }
    }
    exit();
}
/* RECORD OPERATION END */

// start the output buffering
ob_start();
/* search form */
?>
<div style="padding: 5px; background-color: #CCCCCC;">
    <a href="fines_list.php?action=detail" class="headerText2" style="color: #FF0000;"><?php echo lang_mod_circ_tblheader_add_new_fines; ?></a> &nbsp;
    <a href="fines_list.php" class="headerText2"><?php echo lang_mod_circ_tblheader_fines_list; ?></a>&nbsp;
    <a href="fines_list.php?balance=true" class="headerText2"><?php echo lang_mod_circ_tblheader_view_balanced_overdue; ?></a>
</div>
<?php
/* search form end */
/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    /* RECORD FORM */
    $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
    $rec_q = $dbs->query('SELECT * FROM fines WHERE fines_id='.$itemID);
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.lang_sys_common_form_save_change.'" class="button"';

    // form table attributes
    $form->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
    $form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
    $form->table_content_attr = 'class="alterCell2"';

    // edit mode flag set
    if ($rec_q->num_rows > 0) {
        $form->edit_mode = true;
        // record ID for delete process
        $form->record_id = $itemID;
        // form record title
        $form->record_title = 'Fines Detail';
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.lang_sys_common_form_update.'" class="button"';
    }

    /* Form Element(s) */
    // fines dates
    $form->addDateField('finesDate', 'finesMonth', 'finesYear', lang_mod_circ_fines_field_date, $rec_d['fines_date']);
    // fines description
    $form->addTextField('text', 'finesDesc', lang_mod_circ_fines_field_description.'*', $rec_d['description'], 'style="width: 60%;"');
    // fines debet
    $form->addTextField('text', 'debet', lang_mod_circ_fines_field_debit.'*', !empty($rec_d['debet'])?$rec_d['debet']:'0', 'style="width: 60%;"');
    // fines credit
    $form->addTextField('text', 'credit', lang_mod_circ_fines_field_credit, !empty($rec_d['credit'])?$rec_d['credit']:'0', 'style="width: 60%;"');

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox">'.lang_mod_circ_fines_common_info.'<b>'.$rec_d['description'].'</b></div>';
    }
    // print out the form object
    echo $form->printOut();
} else {
    /* FINES LIST */
    $memberID = trim($_SESSION['memberID']);
    // table spec
    $table_spec = 'fines AS f';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('f.fines_id AS \'EDIT\'',
        'f.description AS \''.lang_mod_circ_fines_field_description.'\'',
        'f.fines_date AS \''.lang_mod_circ_fines_field_date.'\'',
        'f.debet AS \''.lang_mod_circ_fines_field_debit.'\'',
        'f.credit AS \''.lang_mod_circ_fines_field_credit.'\'');
    $datagrid->setSQLorder("f.fines_date DESC");

    $criteria = 'f.member_id=\''.$dbs->escape_string($memberID).'\' ';
    // view balanced overdue
    if (isset($_GET['balance'])) {
        $criteria .= ' AND (f.debet=f.credit) ';
    } else {
        $criteria .= ' AND (f.debet!=f.credit) ';
    }
    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $keyword = $dbs->escape_string($_GET['keywords']);
        $criteria .= " AND (f.description LIKE '%$keyword%' OR f.fines_date LIKE '%$keyword%')";
    }
    $datagrid->setSQLCriteria($criteria);

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" style="width: 100%;" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
    // special properties
    $datagrid->using_AJAX = false;
    $datagrid->chbox_property = false;
    $datagrid->column_width = array(0 => '73%');

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, true);
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, lang_sys_common_search_result_info);
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
}
/* main content end */

// get the buffered content
$content = ob_get_clean();
// include the page template
require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
?>
