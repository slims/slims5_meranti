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

/* Member Type Management section */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging_ajax.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');
$can_write = utility::havePrivilege('membership', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.lang_sys_common_no_privilage.'</div>');
}

/* RECORD OPERATION */
if (isset($_POST['saveData']) AND $can_read AND $can_write) {
    // check form validity
    $memberTypeName = trim(strip_tags($_POST['memberTypeName']));
    if (empty($memberTypeName)) {
        utility::jsAlert(lang_mod_member_type_alert_name_noempty);
        exit();
    } else {
        $data['member_type_name'] = $dbs->escape_string($memberTypeName);
        $data['loan_limit'] = trim($_POST['loanLimit']);
        $data['loan_periode'] = trim($_POST['loanPeriode']);
        $data['enable_reserve'] = $_POST['enableReserve'];
        $data['reserve_limit'] = $_POST['reserveLimit'];
        $data['member_periode'] = $_POST['memberPeriode'];
        $data['reborrow_limit'] = $_POST['reborrowLimit'];
        $data['fine_each_day'] = $_POST['fineEachDay'];
        $data['grace_periode'] = $_POST['gracePeriode'];
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
            $update = $sql_op->update('mst_member_type', $data, 'member_type_id='.$updateRecordID);
            if ($update) {
                utility::jsAlert(lang_mod_member_type_common_member_type_updated);
                // update all member expire date
                @$dbs->query('UPDATE member AS m SET expire_date=DATE_ADD(register_date,INTERVAL '.$data['member_periode'].'  DAY)
                    WHERE member_type_id='.$updateRecordID);
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'\', \'post\');</script>';
            } else { utility::jsAlert(lang_mod_member_type_common_fail_to_save_member_type."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            if ($sql_op->insert('mst_member_type', $data)) {
                utility::jsAlert(lang_mod_member_type_common_member_type_saved);
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'\', \'post\');</script>';
            } else { utility::jsAlert(lang_mod_member_type_common_fail_to_save_member_type."\n".$sql_op->error); }
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
        if (!$sql_op->delete('mst_member_type', 'member_type_id='.$itemID)) {
            $error_num++;
        }
    }

    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(lang_mod_membership_common_alert_delete_member_data_success);
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    } else {
        utility::jsAlert(lang_mod_membership_common_alert_delete_member_data_failed);
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    }
    exit();
}
/* RECORD OPERATION END */

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner memberTypeIcon">
    <?php echo strtoupper(lang_mod_membership_member_type); ?> - <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_type.php?action=detail', 'get');" class="headerText2"><?php echo lang_mod_membership_member_type_new_add; ?></a>
    &nbsp; <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_type.php', 'get');" class="headerText2"><?php echo lang_mod_membership_member_type_list; ?></a>
    <hr />
    <form name="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo lang_sys_common_form_search_field; ?> :
    <input type="text" name="keywords" size="30" />
    <input type="button" id="doSearch" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>membership/member_type.php?' + $('search').serialize(), 'post')" value="<?php echo lang_sys_common_form_search; ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
/* search form end */
/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    if (!($can_read AND $can_write)) {
        die('<div class="errorBox">'.lang_sys_common_no_privilege.'</div>');
    }
    /* RECORD FORM */
    $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
    $rec_q = $dbs->query('SELECT * FROM mst_member_type WHERE member_type_id='.$itemID);
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.lang_sys_common_form_save_change.'" class="button"';

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
        $form->record_title = $rec_d['member_type_name'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.lang_sys_common_form_update.'" class="button"';
    }

    /* Form Element(s) */
    // member type name
    $form->addTextField('text', 'memberTypeName', lang_mod_member_type_field_name.'*', $rec_d['member_type_name'], 'style="width: 100%;"');
    // loan limit
    $form->addTextField('text', 'loanLimit', lang_mod_circ_field_loan_limit, $rec_d['loan_limit'], 'size="5"');
    // loan periode
    $form->addTextField('text', 'loanPeriode', lang_mod_circ_field_loan_periode, $rec_d['loan_periode'], 'size="5"');
    // enable reserve
    $enable_resv_chbox[0] = array('1', lang_sys_conf_form_option_enable);
    $enable_resv_chbox[1] = array('0', lang_sys_conf_form_option_disable);
    $form->addRadio('enableReserve', lang_mod_circ_field_reserve, $enable_resv_chbox, !empty($rec_d['enable_reserve'])?$rec_d['enable_reserve']:'1');
    // reserve limit
    $form->addTextField('text', 'reserveLimit', lang_mod_circ_field_reserve_limit, $rec_d['reserve_limit'], 'size="5"');
    // membership periode
    $form->addTextField('text', 'memberPeriode', lang_mod_member_type_field_periode, $rec_d['member_periode'], 'size="5"');
    // reborrow limit
    $form->addTextField('text', 'reborrowLimit', lang_mod_circ_field_reborrow_limit, $rec_d['reborrow_limit'], 'size="5"');
    // fine each day
    $form->addTextField('text', 'fineEachDay', lang_mod_circ_field_fine_each_day, $rec_d['fine_each_day']);
    // overdue grace periode
    $form->addTextField('text', 'gracePeriode', lang_mod_circ_field_grace_periode, $rec_d['grace_periode']);

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox">'.lang_mod_member_type_common_edit_message.' : <b>'.$rec_d['member_type_name'].'</b> <br />'.lang_mod_member_type_common_last_update.' '.$rec_d['last_update'].'</div>'."\n";
    }
    // print out the form object
    echo $form->printOut();
} else {
    /* MEMBER TYPE NAME LIST */
    // table spec
    $table_spec = 'mst_member_type AS mt';

    // create datagrid
    $datagrid = new simbio_datagrid();
    if ($can_read AND $can_write) {
        $datagrid->setSQLColumn('mt.member_type_id',
            'mt.member_type_name AS \''.lang_mod_membership_field_membership_type.'\'',
            'mt.loan_limit AS \''.lang_mod_circ_field_loan_limit.'\'',
            'mt.member_periode AS \''.lang_mod_member_type_field_periode.'\'',
            'mt.reborrow_limit AS \''.lang_mod_circ_field_reborrow_limit.'\'',
            'mt.last_update AS \''.lang_mod_membership_common_last_update.'\'');
    } else {
        $datagrid->setSQLColumn('mt.member_type_name AS \''.lang_mod_membership_field_membership_type.'\'',
            'mt.loan_limit AS \''.lang_mod_circ_field_loan_limit.'\'',
            'mt.member_periode AS \''.lang_mod_member_type_field_periode.'\'',
            'mt.reborrow_limit AS \''.lang_mod_circ_field_reborrow_limit.'\'',
            'mt.last_update AS \''.lang_mod_membership_common_last_update.'\'');
    }
    $datagrid->setSQLorder('member_type_name ASC');

    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
       $keywords = $dbs->escape_string($_GET['keywords']);
       $datagrid->setSQLCriteria("mt.member_type_name LIKE '%$keywords%'");
    }

    // set table and table header attributes
    $datagrid->icon_edit = SENAYAN_WEB_ROOT_DIR.'admin/'.$sysconf['admin_template']['dir'].'/'.$sysconf['admin_template']['theme'].'/edit.gif';
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, ($can_read AND $can_write));
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, lang_sys_common_search_result_info);
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
}
/* main content end */
?>
