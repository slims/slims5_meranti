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

/* Stock Take */

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

// privileges checking
$can_read = utility::havePrivilege('stock_take', 'r');
$can_write = utility::havePrivilege('stock_take', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.lang_sys_common_no_privilage.'</div>');
}
?>
<fieldset class="menuBox">
<div class="menuBoxInner stockTakeIcon">
    <?php echo strtoupper(lang_mod_stocktake); ?>
    <hr />
    <form name="search" action="" id="search" method="get" style="display: inline;"><?php echo lang_sys_common_form_search_field; ?> :
    <input type="text" name="keywords" size="30" />
    <input type="button" onclick="javascript: setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>stock_take/index.php?' + $('search').serialize(), 'post');" value="<?php echo lang_sys_common_form_search; ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
if (isset($_POST['itemID']) AND !empty($_POST['itemID'])) {
    $itemID = (integer)$_POST['itemID'];
    $rec_q = $dbs->query("SELECT
        stock_take_name AS '".lang_mod_stocktake_init_field_name."',
        start_date AS '".lang_mod_stocktake_init_field_start_date."',
        end_date AS '".lang_mod_stocktake_init_field_end_date."',
        init_user AS '".lang_mod_stocktake_init_field_user."',
        total_item_stock_taked AS '".lang_mod_stocktake_total."',
        total_item_lost AS '".lang_mod_stocktake_lost_total."',
        total_item_exists AS '".lang_mod_stocktake_exists_total."',
        total_item_loan AS '".lang_mod_stocktake_loan_total."',
        stock_take_users AS '".lang_mod_stocktake_participants."',
        is_active AS '".lang_mod_stocktake_status."',
        report_file AS '".lang_mod_stocktake_init_field_report_file."'
        FROM stock_take WHERE stock_take_id=".$itemID);
    $rec_d = $rec_q->fetch_assoc();
    // create table object
    $table = new simbio_table();
    $table->table_attr = 'align="center" class="border" cellpadding="5" cellspacing="0"';
    // table header
    $table->setHeader(array($rec_d[lang_mod_stocktake_init_field_name]));
    $table->table_header_attr = 'class="dataListHeader" colspan="3"';
    // initial row count
    $row = 1;
    foreach ($rec_d as $headings => $stk_data) {
        if ($headings == 'stock_take_id') {
            continue;
        } else if ($headings == lang_mod_stocktake_status) {
            if ($stk_data == '1') {
                $stk_data = '<b style="color: #FF0000;">'.lang_mod_stocktake_active_status.'</b>';
            } else {
                $stk_data = 'Finished';
            }
        }
        $table->appendTableRow(array($headings, ':', $stk_data));
        // set cell attribute
        $table->setCellAttr($row, 0, 'class="alterCell" valign="top" style="width: 170px;"');
        $table->setCellAttr($row, 1, 'class="alterCell" valign="top" style="width: 1%;"');
        $table->setCellAttr($row, 2, 'class="alterCell2" valign="top" style="width: auto;"');
        // add row count
        $row++;
    }
    // print out table
    echo $table->printTable();
} else {
    /* STOCK TAKE HISTORY LIST */
    // table spec
    $table_spec = 'stock_take AS st';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('st.stock_take_id',
        'st.stock_take_name AS \''.lang_mod_stocktake_init_field_name.'\'',
        'st.start_date AS \''.lang_mod_stocktake_init_field_start_date.'\'',
        'st.end_date AS \''.lang_mod_stocktake_init_field_end_date.'\'',
        'CONCAT(\'<a href="'.SENAYAN_WEB_ROOT_DIR.FILES_DIR.'/'.REPORT_DIR.'/\', st.report_file, \'" target="_blank">\', st.report_file, \'</a>\') AS \''.lang_mod_stocktake_init_field_report_file.'\'');
    $datagrid->setSQLorder('st.start_date DESC');
    $datagrid->disableSort('Report');

    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $keyword = $dbs->escape_string(trim($_GET['keywords']));
        $words = explode(' ', $keyword);
        if (count($words) > 1) {
            $concat_sql = ' (';
            foreach ($words as $word) {
                $concat_sql .= " (stock_take_name LIKE '%$word%' OR init_user LIKE '%$word%') AND";
            }
            // remove the last AND
            $concat_sql = substr_replace($concat_sql, '', -3);
            $concat_sql .= ') ';
            $datagrid->setSQLCriteria($concat_sql);
        } else {
            $datagrid->setSQLCriteria("stock_take_name LIKE '%$keyword%' OR init_user LIKE '%$keyword%'");
        }
    }

    // set table and table header attributes
    $datagrid->icon_edit = $sysconf['admin_template']['dir'].'/'.$sysconf['admin_template']['theme'].'/edit.gif';
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    $datagrid->chbox_property = false;
    // set delete proccess URL
    $datagrid->delete_URL = $_SERVER['PHP_SELF'];

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, true);
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, lang_sys_common_search_result_info);
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
}
?>
