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

/* Membership Management section */

if (!defined('SENAYAN_BASE_DIR')) {
    // main system configuration
    require '../../../sysconfig.inc.php';
    // start the session
    require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
}

require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging_ajax.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require SIMBIO_BASE_DIR.'simbio_UTILS/simbio_date.inc.php';
require SIMBIO_BASE_DIR.'simbio_FILE/simbio_file_upload.inc.php';

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');
$can_write = utility::havePrivilege('membership', 'w');

if (!$can_read) {
    die('<div class="errorBox">You dont have enough privileges to view this section</div>');
}

/* member update process */
if (isset($_POST['saveData']) AND $can_read AND $can_write) {
    // check form validity
    $memberID = trim($_POST['memberID']);
    $memberName = trim($_POST['memberName']);
    if (empty($memberID) OR empty($memberName)) {
        utility::jsAlert(lang_mod_membership_common_error_no_id_name);
        exit();
    } else {
        $data['member_id'] = $dbs->escape_string($memberID);
        $data['member_name'] = $dbs->escape_string($memberName);
        $data['member_type_id'] = (integer)$_POST['memberTypeID'];
        $data['inst_name'] = trim($dbs->escape_string(strip_tags($_POST['instName'])));
        $data['gender'] = trim($dbs->escape_string(strip_tags($_POST['gender'])));
        $data['birth_date'] = trim($dbs->escape_string(strip_tags($_POST['birthDate'])));
        $data['register_date'] = trim($dbs->escape_string(strip_tags($_POST['regDate'])));
        $data['expire_date'] = trim($dbs->escape_string(strip_tags($_POST['expDate'])));
        // extending membership
        if (isset($_POST['extend']) AND !empty($_POST['extend'])) {
            // get membership periode from database
            $mtype_query = $dbs->query("SELECT member_periode FROM mst_member_type WHERE member_type_id=".$data['member_type_id']);
            $mtype_data = $mtype_query->fetch_row();
            $data['register_date'] = date('Y-m-d');
            $data['expire_date'] = simbio_date::getNextDate($mtype_data[0], $data['register_date']);
        }
        // member since date
        if (!isset($_POST['updateRecordID'])) {
            $data['member_since_date'] = $data['register_date'];
        }
        $data['pin'] = trim($dbs->escape_string(strip_tags($_POST['memberPIN'])));
        $data['member_address'] = trim($dbs->escape_string(strip_tags($_POST['memberAddress'])));
        $data['member_phone'] = trim($dbs->escape_string(strip_tags($_POST['memberPhone'])));
        $data['member_fax'] = trim($dbs->escape_string(strip_tags($_POST['memberFax'])));
        $data['postal_code'] = trim($dbs->escape_string(strip_tags($_POST['memberPostal'])));
        $data['member_notes'] = trim($dbs->escape_string(strip_tags($_POST['memberNotes'])));
        $data['member_email'] = trim($dbs->escape_string(strip_tags($_POST['memberEmail'])));
        $data['is_pending'] = intval($_POST['isPending']);
        $data['input_date'] = date('Y-m-d');
        $data['last_update'] = date('Y-m-d');
        if (!empty($_FILES['image']) AND $_FILES['image']['size']) {
            // create upload object
            $upload = new simbio_file_upload();
            $upload->setAllowableFormat($sysconf['allowed_images']);
            $upload->setMaxSize($sysconf['max_image_upload']*1024); // approx. 100 kb
            $upload->setUploadDir(IMAGES_BASE_DIR.'persons');
            // give new name for upload file
            $new_filename = 'member_'.$data['member_id'];
            $upload_status = $upload->doUpload('image', $new_filename);
            if ($upload_status == UPLOAD_SUCCESS) {
                $data['member_image'] = $dbs->escape_string($upload->new_filename);
            }
        }

        // create sql op object
        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // remove input date
            unset($data['input_date']);
            // filter update record ID
            $updateRecordID = $dbs->escape_string(trim($_POST['updateRecordID']));
            $old_member_ID = $updateRecordID;
            // update the data
            $update = $sql_op->update('member', $data, "member_id='$updateRecordID'");
            if ($update) {
                // update other tables contain this member ID
                @$dbs->query('UPDATE loan SET member_id=\''.$data['member_id'].'\' WHERE member_id=\''.$old_member_ID.'\'');
                @$dbs->query('UPDATE fines SET member_id=\''.$data['member_id'].'\' WHERE member_id=\''.$old_member_ID.'\'');
                utility::jsAlert(lang_mod_membership_common_member_data_updated);
                // upload status alert
                if (isset($upload_status)) {
                    if ($upload_status == UPLOAD_SUCCESS) {
                        // write log
                        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', $_SESSION['realname'].' upload image file '.$upload->new_filename);
                        utility::jsAlert(lang_mod_membership_common_image_upload_success);
                    } else {
                        // write log
                        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', 'ERROR : '.$_SESSION['realname'].' FAILED TO upload image file '.$upload->new_filename.', with error ('.$upload->error.')');
                        utility::jsAlert(lang_mod_membership_common_image_upload_error);
                    }
                }
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', $_SESSION['realname'].' update member data ('.$memberName.') with ID ('.$memberID.')');
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', parent.getPreviousAJAXurl(), \'post\');</script>';
            } else { utility::jsAlert(lang_mod_membership_common_error_fail_to_save_member_data."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            $insert = $sql_op->insert('member', $data);
            if ($insert) {
                utility::jsAlert(lang_mod_membership_common_member_data_saved);
                // upload status alert
                if (isset($upload_status)) {
                    if ($upload_status == UPLOAD_SUCCESS) {
                        // write log
                        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', $_SESSION['realname'].' upload image file '.$upload->new_filename);
                        utility::jsAlert(lang_mod_membership_common_image_upload_success);
                    } else {
                        // write log
                        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', 'ERROR : '.$_SESSION['realname'].' FAILED TO upload image file '.$upload->new_filename.', with error ('.$upload->error.')');
                        utility::jsAlert(lang_mod_membership_common_image_upload_error);
                    }
                }
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', $_SESSION['realname'].' add new member ('.$memberName.') with ID ('.$memberID.')');
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'\', \'get\');</script>';
            } else { utility::jsAlert(lang_mod_membership_common_error_fail_to_save_member_data."\nDEBUG : ".$sql_op->error); }
            exit();
        }
    }
    exit();
} else if (isset($_POST['batchExtend']) && $can_read && $can_write) {
    /* BATCH extend membership proccessing */
    $curr_date = date('Y-m-d');
    $num_extended = 0;
    foreach ($_POST['itemID'] as $itemID) {
        $memberID = $dbs->escape_string(trim($itemID));
        // get membership periode from database
        $mtype_q = $dbs->query('SELECT member_periode, m.member_name FROM member AS m
            LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id
            WHERE m.member_id=\''.$memberID.'\'');
        $mtype_d = $mtype_q->fetch_row();
        $expire_date = simbio_date::getNextDate($mtype_d[0], $curr_date);
        @$dbs->query('UPDATE member SET expire_date=\''.$expire_date.'\' WHERE member_id=\''.$memberID.'\'');
        // write log
        utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', $_SESSION['realname'].' extends membership for member ('.$mtype_d[1].') with ID ('.$memberID.')');
        $num_extended++;
    }
    header('Location: '.MODULES_WEB_ROOT_DIR.'membership/index.php?expire=true&numExtended='.$num_extended);
    exit();
} else if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
    if (!($can_read AND $can_write)) {
        die();
    }
    /* DATA DELETION PROCESS */
    $sql_op = new simbio_dbop($dbs);
    $failed_array = array();
    $error_num = 0;
    $still_have_loan = array();
    if (!is_array($_POST['itemID'])) {
        // make an array
        $_POST['itemID'] = array($dbs->escape_string(trim($_POST['itemID'])));
    }
    // loop array
    foreach ($_POST['itemID'] as $itemID) {
        $itemID = $dbs->escape_string(trim($itemID));
        // check if the member still have loan
        $loan_q = $dbs->query('SELECT DISTINCT m.member_id, m.member_name, COUNT(l.loan_id) FROM member AS m
            LEFT JOIN loan AS l ON (m.member_id=l.member_id AND l.is_lent=1 AND l.is_return=0)
            WHERE m.member_id=\''.$itemID.'\' GROUP BY m.member_id');
        $loan_d = $loan_q->fetch_row();
        if ($loan_d[2] < 1) {
            if (!$sql_op->delete('member', "member_id='$itemID'")) {
                $error_num++;
            } else {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'membership', $_SESSION['realname'].' DELETE member data ('.$loan_d[1].') with ID ('.$loan_d[0].')');
            }
        } else {
            $still_have_loan[] = $loan_d[0].' - '.$loan_d[1];
            $error_num++;
        }
    }

    if ($still_have_loan) {
        $members = '';
        foreach ($still_have_loan as $mbr) {
            $members .= $mbr."\n";
        }
        utility::jsAlert(lang_mod_membership_common_alert_no_delete_member_data.' : '."\n".$mbr);
        exit();
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
<div class="menuBoxInner memberIcon">
    <?php echo strtoupper(lang_mod_membership); ?> - <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>membership/index.php?action=detail', 'get');" class="headerText2"><?php echo lang_mod_membership_add_new_member; ?></a>
    &nbsp; <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>membership/index.php', 'get');" class="headerText2"><?php echo lang_mod_membership_member_list; ?></a>
    &nbsp; <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>membership/index.php?expire=true', 'get');" class="headerText2" style="color: #FF0000;"><?php echo lang_mod_membership_view_expired_member; ?></a>
    <hr />
    <form name="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo lang_mod_membership_search; ?> :
    <input type="text" name="keywords" size="30" /><?php if (isset($_GET['expire'])) { echo '<input type="hidden" name="expire" value="true" />'; } ?>
    <input type="button" id="doSearch" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>membership/index.php?' + $('search').serialize(), 'post')" value="<?php echo lang_mod_membership_search_button; ?>" class="button" />
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
    $itemID = $dbs->escape_string(trim(isset($_POST['itemID'])?$_POST['itemID']:''));
    $rec_q = $dbs->query("SELECT * FROM member WHERE member_id='$itemID'");
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.lang_mod_membership_button_save.'" class="button"';

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
        $form->record_title = $rec_d['member_name'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.lang_sys_common_form_update.'" class="button"';
    }

    /* Form Element(s) */
    if ($form->edit_mode) {
        // check if member expired
        $curr_date = date('Y-m-d');
        $compared_date = simbio_date::compareDates($rec_d['expire_date'], $curr_date);
        $is_expired = ($compared_date == $curr_date);
        $expired_message = '';
        if ($is_expired) {
            // extend membership
            $chbox_array[] = array('1', lang_mod_membership_field_extend);
            $form->addCheckBox('extend', lang_mod_membership_field_extend_membership, $chbox_array);
            $expired_message = '<b style="color: #FF0000;">('.lang_mod_membership_common_error_membership_expired.')</b>';
        }
    }
    // member code
    $str_input = simbio_form_element::textField('text', 'memberID', $rec_d['member_id'], 'id="memberID" onblur="ajaxCheckID(\''.SENAYAN_WEB_ROOT_DIR.'admin/AJAX_check_id.php\', \'member\', \'member_id\', \'msgBox\', \'memberID\')" style="width: 30%;"');
    $str_input .= ' &nbsp; <span id="msgBox">&nbsp;</span>';
    $form->addAnything(lang_mod_membership_field_member_id.'*', $str_input);
    // member name
    $form->addTextField('text', 'memberName', lang_mod_membership_field_name.'*', $rec_d['member_name'], 'style="width: 100%;"');
    // member birth date
    $form->addDateField('birthDate', lang_mod_membership_field_birth_date, $rec_d['birth_date']);
    if ($form->edit_mode) {
        // member since
        $form->addAnything(lang_mod_membership_field_member_since, $rec_d['member_since_date']);
    }
    // member register date
    $form->addDateField('regDate', lang_mod_membership_field_register_date, $rec_d['register_date']);
    // member expire date
    if ($form->edit_mode) {
        $form->addDateField('expDate', lang_mod_membership_field_expiry_date, $rec_d['expire_date']);
    } else {
        $chbox_array[] = array('1', 'Auto Set');
        $str_input = '<div>'.simbio_form_element::checkBox('extend', $chbox_array, '1').'</div>';
        $str_input .= '<div>'.simbio_form_element::dateField('expDate', $rec_d['expire_date']).'</div>';
        $form->addAnything(lang_mod_membership_field_expiry_date.'*', $str_input);
    }
    // member institution
    $form->addTextField('text', 'instName', lang_mod_membership_field_institution, $rec_d['inst_name'], 'style="width: 100%;"');
    // member type
        // get mtype data related to this record from database
        $mtype_query = $dbs->query("SELECT member_type_id, member_type_name FROM mst_member_type");
        $mtype_options = array();
        while ($mtype_data = $mtype_query->fetch_row()) {
            $mtype_options[] = array($mtype_data[0], $mtype_data[1]);
        }
    $form->addSelectList('memberTypeID', lang_mod_membership_field_membership_type, $mtype_options, $rec_d['member_type_id']);
    // member gender
    $gender_chbox[0] = array('1', lang_mod_membership_field_gender_opt1);
    $gender_chbox[1] = array('0', lang_mod_membership_field_gender_opt2);
    $form->addRadio('gender', lang_mod_membership_field_gender, $gender_chbox, !empty($rec_d['gender'])?$rec_d['gender']:'0');
    // member email
    $form->addTextField('text', 'memberEmail', lang_mod_membership_field_email, $rec_d['member_email'], 'style="width: 60%;"');
    // member address
    $form->addTextField('textarea', 'memberAddress', lang_mod_membership_field_address, $rec_d['member_address'], 'rows="2" style="width: 100%;"');
    // member postal
    $form->addTextField('text', 'memberPostal', lang_mod_membership_field_postal_code, $rec_d['postal_code'], 'style="width: 60%;"');
    // member phone
    $form->addTextField('text', 'memberPhone', lang_mod_membership_field_phone_number, $rec_d['member_phone'], 'style="width: 60%;"');
    // member fax
    $form->addTextField('text', 'memberFax', lang_mod_membership_field_fax_number, $rec_d['member_fax'], 'style="width: 60%;"');
    // member pin
    $form->addTextField('text', 'memberPIN', lang_mod_membership_field_personal_id, $rec_d['pin'], 'style="width: 100%;"');
    // member notes
    $form->addTextField('textarea', 'memberNotes', lang_mod_membership_field_notes, $rec_d['member_notes'], 'rows="2" style="width: 100%;"');
    // member is_pending
    $form->addCheckBox('isPending', lang_mod_membership_field_pending, array( array('1', 'Yes') ), $rec_d['is_pending']);
    // member photo
    if ($rec_d['member_image']) {
        $str_input = '<a href="'.SENAYAN_WEB_ROOT_DIR.'images/persons/'.$rec_d['member_image'].'" target="_blank"><strong>'.$rec_d['member_image'].'</strong></a><br />';
        $str_input .= simbio_form_element::textField('file', 'image');
        $str_input .= ' '.lang_mod_membership_common_maximum.' '.$sysconf['max_image_upload'].' KB';
        $form->addAnything(lang_mod_membership_field_photo, $str_input);
    } else {
        $str_input = simbio_form_element::textField('file', 'image');
        $str_input .= ' '.lang_mod_membership_common_maximum.' '.$sysconf['max_image_upload'].' KB';
        $form->addAnything(lang_mod_membership_field_photo, $str_input);
    }

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox" style="overflow: auto;">'
            .'<div style="float: left; width: 80%;">'.lang_mod_membership_common_edit_message.' : <b>'.$rec_d['member_name'].'</b> <br />'.lang_mod_membership_common_last_update.' '.$rec_d['last_update'].' '.$expired_message.'</div>';
            if ($rec_d['member_image']) {
                if (file_exists(IMAGES_BASE_DIR.'persons/'.$rec_d['member_image'])) {
                    echo '<div style="float: right;"><img src="../lib/phpthumb/phpThumb.php?src=../../images/persons/'.urlencode($rec_d['member_image']).'&w=53" style="border: 1px solid #999999" /></div>';
                }
            }
        echo'</div>'."\n";
    }
    // print out the form object
    echo $form->printOut();
} else {
    /* MEMBERSHIP LIST */
    // table spec
    $table_spec = 'member AS m
        LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id';

    // create datagrid
    $datagrid = new simbio_datagrid();
    if ($can_read AND $can_write) {
        $datagrid->setSQLColumn('m.member_id',
            'm.member_id AS \''.lang_mod_membership_field_member_id.'\'',
            'm.member_name AS \''.lang_mod_membership_field_name.'\'',
            'mt.member_type_name AS \''.lang_mod_membership_field_membership_type.'\'',
            'm.member_email AS \''.lang_mod_membership_field_email.'\'',
            'm.last_update AS \''.lang_mod_membership_common_last_update.'\'');
    } else {
        $datagrid->setSQLColumn('m.member_id AS \''.lang_mod_membership_field_member_id.'\'',
            'm.member_name AS \''.lang_mod_membership_field_name.'\'',
            'mt.member_type_name AS \''.lang_mod_membership_field_membership_type.'\'',
            'm.member_email AS \''.lang_mod_membership_field_email.'\'',
            'm.last_update AS \''.lang_mod_membership_common_last_update.'\'');
    }
    $datagrid->setSQLorder('member_name ASC');

    // is there any search
    $criteria = 'm.member_id IS NOT NULL ';
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
       $keywords = $dbs->escape_string($_GET['keywords']);
       $criteria .= " AND (m.member_name LIKE '%$keywords%' OR m.member_id LIKE '%$keywords%') ";
    }
    if (isset($_GET['expire'])) {
        $criteria .= " AND TO_DAYS('".date('Y-m-d')."')>TO_DAYS(m.expire_date)";
    }
    $datagrid->setSQLCriteria($criteria);

    // set table and table header attributes
    $datagrid->icon_edit = SENAYAN_WEB_ROOT_DIR.'admin/'.$sysconf['admin_template']['dir'].'/'.$sysconf['admin_template']['theme'].'/edit.gif';
    $datagrid->table_name = 'memberList';
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, ($can_read AND $can_write));
    if ((isset($_GET['keywords']) AND $_GET['keywords']) OR isset($_GET['expire'])) {
        echo '<div class="infoBox">';
        if (isset($_GET['expire'])) {
            echo '<b style="color: #FF0000;">'.lang_mod_membership_common_expired_member_list.'</b><hr size="1" />';
            echo '<div><input type="button" value="Extend Selected Member(s)" onclick="javascript: if (confirm(\'Are you sure to EXTEND membership for selected members?\')) { setContent(\'mainContent\', \''.MODULES_WEB_ROOT_DIR.'membership/index.php?expire=1\', \'post\', $H($(\'memberList\').serialize(true)).update({ batchExtend: \'true\' }) ); }" class="button" /></div>';
            if (isset($_GET['numExtended']) AND $_GET['numExtended'] > 0) {
                echo '<div><strong>'.$_GET['numExtended'].'</strong> members extended!</div>';
            }
        }
        if (isset($_GET['keywords']) AND $_GET['keywords']) {
            echo lang_mod_membership_common_found_text_1.' '.$datagrid->num_rows.' '.lang_mod_membership_common_found_text_2.' : "'.$_GET['keywords'].'"';
        }
        echo '</div>';
    }

    echo $datagrid_result;
}
/* main content end */
?>
