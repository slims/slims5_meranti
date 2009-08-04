<?php
/**
 *
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

/* Application Holidays Management section */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/template_parser/simbio_template_parser.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging_ajax.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require SIMBIO_BASE_DIR.'simbio_UTILS/simbio_date.inc.php';

// privileges checking
$can_read = utility::havePrivilege('system', 'r');
$can_write = utility::havePrivilege('system', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.lang_sys_common_no_privilege.'</div>');
}

/* RECORD OPERATION */
if (isset($_POST['saveData']) AND $can_read AND $can_write) {
    // check form validity
    $holDesc = trim($dbs->escape_string(strip_tags($_POST['holDesc'])));
    if (empty($holDesc)) {
        utility::jsAlert('Holiday description can\'t be empty!');
        exit();
    } else {
        $data['holiday_date'] = trim(preg_replace('@\s[0-9]{2}:[0-9]{2}:[0-9]{2}$@i', '', $_POST['holDate']));
        $holiday_start_date = $data['holiday_date'];
        $data['holiday_dayname'] = date('D', strtotime($data['holiday_date']));
        $data['description'] = $holDesc;

        // create sql op object
        $sql_op = new simbio_dbop($dbs);
        if (isset($_POST['updateRecordID'])) {
            /* UPDATE RECORD MODE */
            // filter update record ID
            $updateRecordID = (integer)$_POST['updateRecordID'];
            if ($sql_op->update('holiday', $data, 'holiday_id='.$updateRecordID)) {
                utility::jsAlert(lang_sys_conf_holiday_alert_update_ok);
                // update holiday_dayname session
                $_SESSION['holiday_date'][$data['holiday_date']] = $data['holiday_date'];
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', parent.getPreviousAJAXurl(), \'post\');</script>';
                exit();
            } else {
                utility::jsAlert(lang_sys_conf_holiday_alert_update_fail."\n".$sql_op->error);
            }
        } else {
            /* INSERT RECORD MODE */
            // insert the data
            if ($sql_op->insert('holiday', $data)) {
                utility::jsAlert(lang_sys_conf_holiday_alert_save_ok);
                // update holiday_dayname session
                $_SESSION['holiday_date'][$data['holiday_date']] = $data['holiday_date'];
                // date range insert
                if (isset($_POST['holDateEnd'])) {
                    $holiday_end_date = trim(preg_replace('@\s[0-9]{2}:[0-9]{2}:[0-9]{2}$@i', '', $_POST['holDateEnd']));
                    // check if holiday end date is more than holiday start date
                    if (simbio_date::compareDates($holiday_start_date, $holiday_end_date) == $holiday_end_date) {
                        $guard = 365;
                        $d = 1;
                        while ($holiday_start_date != $holiday_end_date) {
                            if ($d == $guard) {
                                break;
                            }
                            $holiday_start_date = simbio_date::getNextDate(1, $holiday_start_date);
                            list($date_year, $date_month, $date_date) = explode('-', $holiday_start_date);
                            $data['holiday_date'] = $holiday_start_date;
                            $data['holiday_dayname'] = date('D', mktime(0, 0, 0, $date_month, $date_date, $date_year));
                            @$sql_op->insert('holiday', $data);
                            $_SESSION['holiday_date'][$holiday_start_date] = $holiday_start_date;
                            $d++;
                        }
                    }
                }
                echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?mode=special\', \'get\');</script>';
                exit();
            } else {
                utility::jsAlert(lang_sys_conf_holiday_alert_save_fail."\n".$sql_op->error);
            }
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
        // get info about this holiday
        $rec_q = $dbs->query('SELECT holiday_date FROM holiday WHERE holiday_id='.$itemID);
        $rec_d = $rec_q->fetch_row();
        if (!$sql_op->delete('holiday', 'holiday_id='.$itemID)) {
            $error_num++;
        } else {
            // remove session for this holiday
            unset($_SESSION['holiday_date'][$rec_d[0]]);
        }
    }

    // error alerting
    if ($error_num == 0) {
        utility::jsAlert(lang_sys_conf_holiday_common_alert_delete_success);
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    } else {
        utility::jsAlert(lang_sys_conf_holiday_common_alert_delete_fail);
        echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'?'.$_POST['lastQueryStr'].'\', \'post\');</script>';
    }
    exit();
}
/* RECORD OPERATION */

?>
<fieldset class="menuBox">
<div class="menuBoxInner calendarIcon">
    <?php echo strtoupper(lang_sys_holiday); ?>
    <hr />
    <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>system/holiday.php', 'post');" class="headerText2"><?php echo lang_sys_holiday_set_day; ?></a>
    &nbsp; <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>system/holiday.php?mode=special', 'get');" class="headerText2"><?php echo lang_sys_holiday_list; ?></a>
    &nbsp; <a href="#" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>system/holiday.php?mode=special&action=detail', 'get');" class="headerText2"><?php echo lang_sys_holiday_add_day; ?></a>
</div>
</fieldset>
<?php
if (isset($_GET['mode'])) {
    if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
        /* SPECIAL HOLIDAY RECORD FORM */
        $itemID = (integer)isset($_POST['itemID'])?$_POST['itemID']:0;
        $rec_q = $dbs->query('SELECT * FROM holiday WHERE holiday_id='.$itemID);
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
            $form->record_id = $itemID;
            // form record title
            $form->record_title = $rec_d['description'];
            // submit button attribute
            $form->submit_button_attr = 'name="saveData" value="'.lang_sys_common_form_update.'" class="button"';
        }

        /* Form Element(s) */
        // holiday date start
        $form->addDateField('holDate', lang_sys_conf_holiday_field_date_day, $rec_d['holiday_date']);
        // holiday date end
        if (!$form->edit_mode) {
            $form->addDateField('holDateEnd', lang_sys_conf_holiday_field_date_day_end, $rec_d['holiday_date']);
        }
        // holiday description
        $form->addTextField('text', 'holDesc', lang_sys_conf_holiday_field_description.'*', $rec_d['description'], 'style="width: 100%;"');

        // edit mode messagge
        if ($form->edit_mode) {
            echo '<div class="infoBox">'.lang_sys_conf_holiday_common_edit_info.' : <b>'.$rec_d['description'].'</b></div>';
        }
        // print out the form object
        echo $form->printOut();
    } else {
        /* HOLIDAY LIST */
        // table spec
        $table_spec = 'holiday';

        // create datagrid
        $datagrid = new simbio_datagrid();
        if ($can_read AND $can_write) {
            $datagrid->setSQLColumn('holiday_id',
                "holiday_dayname AS '".lang_sys_conf_holiday_field_day_name."'",
                "holiday_date AS '".lang_sys_conf_holiday_field_date_day."'",
                "description AS '".lang_sys_conf_holiday_field_description."'");
        } else {
            $datagrid->setSQLColumn("holiday_dayname AS '".lang_sys_conf_holiday_field_day_name."'",
                "holiday_date AS '".lang_sys_conf_holiday_field_date_day."'",
                "description AS '".lang_sys_conf_holiday_field_description."'");
        }
        $datagrid->setSQLorder('holiday_date DESC');

        // is there any search
        if (isset($_GET['keywords']) AND $_GET['keywords']) {
           $keywords = $dbs->escape_string($_GET['keywords']);
           $datagrid->setSQLCriteria("holiday_description LIKE '%$keywords%' OR holiday_date LIKE '%$keywords%'");
        } else {
            $datagrid->setSQLCriteria('holiday_date IS NOT NULL');
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
} else {
    // holiday setting saving proccess
    if (isset($_POST['dayname'])) {
        // make sure that not all day selected
        if (count($_POST['dayname']) > 6) {
            echo '<div class="errorBox">'.lang_sys_common_holiday_set_error.'</div>';
        } else {
            // delete previous holiday dayname settings
            $dbs->query('DELETE FROM holiday WHERE holiday_date IS NULL');
            if ($_POST['dayname']) {
                // emptying holiday dayname session first
                $_SESSION['holiday_dayname'] = array();
                foreach ($_POST['dayname'] as $dayname) {
                    $dbs->query("INSERT INTO holiday VALUES(NULL, '$dayname', NULL, NULL)");
                    // update holiday_dayname session
                    $_SESSION['holiday_dayname'][] = $dayname;
                }
                // information box
                echo '<div class="infoBox">'.lang_sys_conf_holiday_alert_set_ok.'</div>';
            }
        }
    }

    // get holiday data from database
    $rec_q = $dbs->query('SELECT DISTINCT holiday_dayname FROM holiday WHERE holiday_date IS NULL');
    // fetch holiday data
    $hol_dayname = array();
    if ($rec_q->num_rows > 0) {
        while ($rec_d = $rec_q->fetch_row()) {
            $hol_dayname[] = $rec_d[0];
        }
    }

    // small function to check the checkbox
    function isChecked($str_data)
    {
        global $hol_dayname;
        if (in_array($str_data, $hol_dayname)) {
            return 'checked';
        }
    }

    // create table object
    $table = new simbio_table();
    $table->table_attr = 'align="center" class="border fullWidth" cellpadding="5" cellspacing="0"';

    // dayname list
    $table->appendTableRow(array('<input type="checkbox" name="dayname[]" value="mon" '.isChecked('mon').' /> '.lang_sys_conf_holiday_field_day_1,
        '<input type="checkbox" name="dayname[]" value="tue" '.isChecked('tue').' /> '.lang_sys_conf_holiday_field_day_2,
        '<input type="checkbox" name="dayname[]" value="wed" '.isChecked('wed').' /> '.lang_sys_conf_holiday_field_day_3));

    $table->appendTableRow(array('<input type="checkbox" name="dayname[]" value="thu" '.isChecked('thu').' /> '.lang_sys_conf_holiday_field_day_4,
        '<input type="checkbox" name="dayname[]" value="fri" '.isChecked('fri').' /> '.lang_sys_conf_holiday_field_day_5,
        '<input type="checkbox" name="dayname[]" value="sat" '.isChecked('sat').' /> '.lang_sys_conf_holiday_field_day_6));

    $table->appendTableRow(array('<input type="checkbox" name="dayname[]" value="sun" '.isChecked('sun').' /> '.lang_sys_conf_holiday_field_day_7));
    // set cell attribute
    $table->setCellAttr(3, 0, 'colspan="3"');

    // submit button
    $table->appendTableRow(array('<input type="button" name="saveDaynameData" value="'.lang_sys_conf_holiday_form_save.'" onclick="setContent(\'mainContent\', \''.$_SERVER['PHP_SELF'].'\', \'post\', $(\'holidayForm\').serialize())" />'));
    // set cell attribute
    $table->setCellAttr(4, 0, 'colspan="3" class="alterCell"');

    echo '<form name="holidayForm" id="holidayForm">';
    echo $table->printTable();
    echo '</form>';
}
?>
