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

/* Staffs/Application Users Management section */

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('system', 'r');
$can_write = utility::havePrivilege('system', 'w');

// check if we want to change current user profile
$changecurrent = false;
if (isset($_GET['changecurrent'])) {
    $changecurrent = true;
}

if (!$changecurrent) {
    // only administrator have privileges add/edit users
    if ($_SESSION['uid'] != 1) {
        die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
    }
}

/* RECORD OPERATION */
if (isset($_POST['saveData'])) {
    $userName = trim(strip_tags($_POST['userName']));
    $realName = trim(strip_tags($_POST['realName']));
    $passwd1 = trim($_POST['passwd1']);
    $passwd2 = trim($_POST['passwd2']);
    // check form validity
    if (empty($userName) OR empty($realName)) {
        utility::jsAlert(__('User Name or Real Name can\'t be empty'));
        exit();
    } else if (($userName == 'admin' OR $realName == 'Administrator') AND $_SESSION['uid'] != 1) {
        utility::jsAlert(__('Login username or Real Name is probihited!'));
        exit();
    } else if (($passwd1 AND $passwd2) AND ($passwd1 !== $passwd2)) {
        utility::jsAlert(__('Password confirmation does not match. See if your Caps Lock key is on!'));
        exit();
    } else {
        $data['username'] = $dbs->escape_string($userName);
        $data['realname'] = $dbs->escape_string($realName);
        if (isset($_POST['noChangeGroup'])) {
            // parsing groups data
            $groups = '';
            if (isset($_POST['groups']) AND !empty($_POST['groups'])) {
                $groups = serialize($_POST['groups']);
            } else {
                $groups = 'literal{NULL}';
            }
            $data['groups'] = trim($groups);
        }
        if (($passwd1 AND $passwd2) AND ($passwd1 === $passwd2)) {
            $data['passwd'] = 'literal{MD5(\''.$passwd2.'\')}';
        }
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
            $update = $sql_op->update('user', $data, 'user_id='.$updateRecordID);
            if ($update) {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' update user data ('.$data['realname'].') with username ('.$data['username'].')');
                utility::jsAlert(__('User Data Successfully Updated'));
                echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(parent.$.ajaxHistory[0].url);</script>';
            } else { utility::jsAlert(__('User Data FAILED to Updated. Please Contact System Administrator')."\nDEBUG : ".$sql_op->error); }
            exit();
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            if ($sql_op->insert('user', $data)) {
                // write log
                utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' add new user ('.$data['realname'].') with username ('.$data['username'].')');
                utility::jsAlert(__('New User Data Successfully Saved'));
                echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'\');</script>';
            } else { utility::jsAlert(__('User Data FAILED to Save. Please Contact System Administrator')."\n".$sql_op->error); }
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
        // get user data
        $user_q = $dbs->query('SELECT username, realname FROM user WHERE user_id='.$itemID);
        $user_d = $user_q->fetch_row();
        if (!$sql_op->delete('user', "user_id='$itemID'")) {
            $error_num++;
        } else {
            // write log
            utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' DELETE user ('.$user_d[1].') with username ('.$user_d[0].')');
        }
    }

    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(__('All Data Successfully Deleted'));
        echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\');</script>';
    } else {
        utility::jsAlert(__('Some or All Data NOT deleted successfully!\nPlease contact system administrator'));
        echo '<script type="text/javascript">parent.$(\'#mainContent\').simbioAJAX(\''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\');</script>';
    }
    exit();
}
/* RECORD OPERATION END */

if (!$changecurrent) {
/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner userIcon">
    <?php echo strtoupper(__('System Users')); ?> - <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>system/app_user.php?action=detail" class="headerText2"><?php echo __('Add New User'); ?></a>
    &nbsp; <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>/system/app_user.php" class="headerText2"><?php echo __('User List'); ?></a>
    <hr />
    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>system/app_user.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" size="30" />
    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
/* search form end */
}

/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    if (!($can_read AND $can_write) AND !$changecurrent) {
        die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
    }
    /* RECORD FORM */
    // try query
    $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
    if ($changecurrent) {
        $itemID = (integer)$_SESSION['uid'];
    }
    $rec_q = $dbs->query('SELECT * FROM user WHERE user_id='.$itemID);
    $rec_d = $rec_q->fetch_assoc();

    // create new instance
    $form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
    $form->submit_button_attr = 'name="saveData" value="'.__('Save').'" class="button"';

    // form table attributes
    $form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
    $form->table_content_attr = 'class="alterCell2"';

    // edit mode flag set
    if ($rec_q->num_rows > 0) {
        $form->edit_mode = true;
        // record ID for delete process
        if (!$changecurrent) {
            // form record id
            $form->record_id = $itemID;
        } else {
            $form->addHidden('updateRecordID', $itemID);
            $form->back_button = false;
        }
        // form record title
        $form->record_title = $rec_d['realname'];
        // submit button attribute
        $form->submit_button_attr = 'name="saveData" value="'.__('Update').'" class="button"';
    }

    /* Form Element(s) */
    // user name
    $form->addTextField('text', 'userName', __('Login Username').'*', $rec_d['username'], 'style="width: 50%;"');
    // user real name
    $form->addTextField('text', 'realName', __('Real Name').'*', $rec_d['realname'], 'style="width: 50%;"');
    // user group
    // only appear by user who hold system module privileges
    if (!$changecurrent AND $can_read AND $can_write) {
        // add hidden element as a flag that we dont change group data
        $form->addHidden('noChangeGroup', '1');
        // user group
        $group_query = $dbs->query('SELECT group_id, group_name FROM
            user_group WHERE group_id != 1');
        // initiliaze group options
        $group_options = array();
        while ($group_data = $group_query->fetch_row()) {
            $group_options[] = array($group_data[0], $group_data[1]);
        }
        $form->addCheckBox('groups', __('Group(s)'), $group_options, unserialize($rec_d['groups']));
    }
    // user password
    $form->addTextField('password', 'passwd1', __('New Password').'*', '', 'style="width: 50%;"');
    // user password confirm
    $form->addTextField('password', 'passwd2', __('Confirm New Password').'*', '', 'style="width: 50%;"');

    // edit mode messagge
    if ($form->edit_mode) {
        echo '<div class="infoBox">'.__('You are going to edit user profile'),' : <b>'.$rec_d['realname'].'</b> <br />'.__('Last Update').$rec_d['last_update'].' //mfc
            <br />'.__('Leave Password field blank if you don\'t want to change the password').'</div>';
    }
    // print out the form object
    echo $form->printOut();
} else {
    // only administrator have privileges to view user list
    if (!($can_read AND $can_write) OR $_SESSION['uid'] != 1) {
        die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
    }

    /* USER LIST */
    // table spec
    $table_spec = 'user AS u';

    // create datagrid
    $datagrid = new simbio_datagrid();
    if ($can_read AND $can_write) {
        $datagrid->setSQLColumn('u.user_id',
            'u.realname AS \''.__('Real Name').'\'',
            'u.username AS \''.__('Login Username').'\'',
            'u.last_login AS \''.__('Last Login').'\'',
            'u.last_update AS \''.__('Last Update').'\'');
    } else {
        $datagrid->setSQLColumn('u.realname AS \''.__('Real Name').'\'',
            'u.username AS \''.__('Real Name').'\'',
            'u.last_login AS \''.__('Last Login').'\'',
            'u.last_update AS \''.__('Last Update').'\'');
    }
    $datagrid->setSQLorder('username ASC');

    // is there any search
    $criteria = 'u.user_id != 1 ';
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
       $keywords = $dbs->escape_string($_GET['keywords']);
       $criteria .= " AND (u.username LIKE '%$keywords%' OR u.realname LIKE '%$keywords%')";
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
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
}
/* main content end */
?>
