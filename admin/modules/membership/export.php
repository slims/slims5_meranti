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

/* Member data export section */

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

if (isset($_POST['doExport'])) {
    // check for form validity
    if (empty($_POST['fieldSep']) OR empty($_POST['fieldEnc'])) {
        utility::jsAlert(lang_mod_member_export_alert_required_noempty);
        exit();
    } else {
        // set PHP time limit
        set_time_limit(3600);
        // limit
        $sep = trim($_POST['fieldSep']);
        $encloser = trim($_POST['fieldEnc']);
        $limit = intval($_POST['recordNum']);
        $offset = intval($_POST['recordOffset']);
        if ($_POST['recordSep'] === 'NEWLINE') {
            $rec_sep = "\n";
        } else if ($_POST['recordSep'] === 'RETURN') {
            $rec_sep = "\r";
        } else {
            $rec_sep = trim($_POST['recordSep']);
        }
        // fetch all data from biblio table
        $sql = "SELECT
            m.member_id, m.member_name, m.gender,
            mt.member_type_name, m.member_email, m.member_address,
            m.postal_code, m.inst_name, m.is_new,
            m.member_image, m.pin, m.member_phone,
            m.member_fax, m.member_since_date, m.register_date,
            m.expire_date, m.member_notes
            FROM member AS m
            LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id ";
        if ($limit > 0) { $sql .= ' LIMIT '.$limit; }
        if ($offset > 1) {
            if ($limit > 0) {
                $sql .= ' OFFSET '.($offset-1);
            } else {
                $sql .= ' LIMIT '.($offset-1).',99999999999';
            }
        }
        // for debugging purpose only
        // die($sql);
        $all_data_q = $dbs->query($sql);
        if ($dbs->error) {
            utility::jsAlert(lang_mod_member_export_alert_query_fail);
        } else {
            if ($all_data_q->num_rows > 0) {
                header('Content-type: text/plain');
                header('Content-Disposition: attachment; filename="senayan_member_export.csv"');
                while ($member_data = $all_data_q->fetch_assoc()) {
                    $buffer = null;
                    foreach ($member_data as $fld_data) {
                        $fld_data = $dbs->escape_string($fld_data);
                        // data
                        $buffer .=  $encloser.$fld_data.$encloser;
                        // field separator
                        $buffer .= $sep;
                    }
                    // remove the last field separator
                    $buffer = substr_replace($buffer, '', -1);
                    echo $buffer;
                    echo $rec_sep;
                }
                exit();
            } else {
                utility::jsAlert(lang_mod_member_export_alert_fail);
            }
        }
    }
    exit();
}

?>
<fieldset class="menuBox">
<div class="menuBoxInner exportIcon">
    <?php echo strtoupper(lang_mod_membership_export_data).'<hr />'.lang_mod_membership_export_data_description; ?>
</div>
</fieldset>
<?php

// create new instance
$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'', 'post');
$form->submit_button_attr = 'name="doExport" value="'.lang_mod_member_export_button_start.'" class="button"';

// form table attributes
$form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';

/* Form Element(s) */
// field separator
$form->addTextField('text', 'fieldSep', lang_mod_member_export_field_field_separator.'*', ''.htmlentities(',').'', 'style="width: 10%;"');
//  field enclosed
$form->addTextField('text', 'fieldEnc', lang_mod_member_export_field_field_enclosed, ''.htmlentities('"').'', 'style="width: 10%;"');
// record separator
$rec_sep_options[] = array('NEWLINE', 'NEWLINE');
$rec_sep_options[] = array('RETURN', 'CARRIAGE RETURN');
$form->addSelectList('recordSep', lang_mod_member_export_field_record_separator, $rec_sep_options);
// number of records to export
$form->addTextField('text', 'recordNum', lang_mod_member_export_field_record_number, '0', 'style="width: 10%;"');
// records offset
$form->addTextField('text', 'recordOffset', lang_mod_member_export_field_record_offset, '1', 'style="width: 10%;"');
// output the form
echo $form->printOut();
?>
