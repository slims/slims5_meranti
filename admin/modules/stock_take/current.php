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

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging_ajax.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';

// privileges checking
$can_read = utility::havePrivilege('stock_take', 'r');
$can_write = utility::havePrivilege('stock_take', 'w');

if (!($can_read AND $can_write)) {
    die('<div class="errorBox">'.lang_sys_common_no_privilage.'</div>');
}

// show only current user stock take item flag
if (isset($_GET['listShow']) && $_GET['listShow'] == '1') {
    $show_only_current = 1;
}

// check if there is any active stock take proccess
$stk_query = $dbs->query('SELECT * FROM stock_take WHERE is_active=1');
if ($stk_query->num_rows < 1) {
    echo '<div class="errorBox">'.lang_mod_stocktake_report_not_initialize.'</div>';
} else {
    // check view mode
    $view = 'e';
    if (isset($_GET['view']) AND $_GET['view']) {
        $view = trim($_GET['view']);
    }
?>
    <fieldset class="menuBox">
    <div class="menuBoxInner stockTakeIcon">
        <?php
        if ($view != 'm') {
          echo lang_mod_stocktake_current_welcome.'<hr />
              <form name="stockTakeForm" action="'.MODULES_WEB_ROOT_DIR.'stock_take/stock_take_action.php" target="stockTakeAction" method="post" style="display: inline;">
              <div><div style="width: 140px; float: left;">'.lang_mod_biblio_item_field_itemcode.':</div><input type="text" id="itemCode" name="itemCode" size="30" /> <input type="submit" value="'.lang_mod_stocktake_current_form_button_change.'" class="button" /></div>
              <div style="margin-top: 3px;"><div style="width: 140px; float: left;">'.lang_mod_stocktake_current_form_list.':</div>
              <input type="radio" id="listShow" name="listShow" value="1" onclick="setContent(\'mainContent\', \''.MODULES_WEB_ROOT_DIR.'stock_take/current.php?listShow=1\', \'get\')" '.( isset($show_only_current)?'checked="checked"':'' ).' /> '.lang_mod_stocktake_current_form_opt_user_cur.'
              <input type="radio" id="listShow2" name="listShow" value="0" onclick="setContent(\'mainContent\', \''.MODULES_WEB_ROOT_DIR.'stock_take/current.php?listShow=0\', \'get\')" '.( isset($show_only_current)?'':'checked="checked"' ).' /> '.lang_mod_stocktake_current_form_opt_user_all.'
              <iframe name="stockTakeAction" style="width: 0; height: 0; visibility: hidden;"></iframe></div>
              </form>';
        } else {
          echo lang_mod_stocktake_current_welcome_alt.'<hr />';
        }
        ?>
        <form name="search" id="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" method="get" style="display: inline;">
        <div style="margin-top: 3px;"><div style="width: 90px; float: left;"><?php echo lang_sys_common_form_search_field; ?> : </div><input type="text" name="keywords" size="30" /> <input type="hidden" name="view" value="<?php echo $view; ?>" /> <input type="submit" id="doSearch" onclick="setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>stock_take/current.php?' + $('search').serialize(), 'post')" value="<?php echo lang_sys_common_form_search; ?>" class="button" /></div>
        </form>
    </div>
    </fieldset>
    <!-- give focus to itemCode text field -->
    <script type="text/javascript">
    Form.Element.focus('itemCode');
    </script>
    <div id="stError" class="errorBox" style="display: none;">&nbsp;</div>
<?php
    /* CURRENT STOCK TAKE ITEM LIST */
    // table spec
    $table_spec = 'stock_take_item AS sti';

    // create datagrid
    $datagrid = new simbio_datagrid();
    $datagrid->setSQLColumn('item_code AS \''.lang_mod_biblio_item_field_itemcode.'\'',
        'title AS \''.lang_mod_biblio_field_title.'\'',
        'coll_type_name AS \''.lang_mod_masterfile_colltype_form_field_colltype.'\'',
        'classification AS \''.lang_mod_biblio_field_class.'\'',
        'IF(sti.status=\'e\', \''.lang_mod_biblio_item_common_status_exists.'\', IF(sti.status=\'l\', \''.lang_mod_biblio_item_common_status_onloan.'\', \''.lang_mod_biblio_item_common_status_missing.'\')) AS \'Status\'');
    $datagrid->setSQLorder("last_update DESC");

    $criteria = 'item_id <> 0 ';
    // is there any search
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $keyword = $dbs->escape_string(trim($_GET['keywords']));
        $words = explode(' ', $keyword);
        if (count($words) > 1) {
            $concat_sql = ' (';
            foreach ($words as $word) {
                $concat_sql .= " (title LIKE '%$word%' OR item_code LIKE '%$word%') AND";
            }
            // remove the last AND
            $concat_sql = substr_replace($concat_sql, '', -3);
            $concat_sql .= ') ';
            $criteria .= ' AND '.$concat_sql." AND status='".$view."'";
        } else {
            $criteria .= " AND (title LIKE '%$keyword%' OR item_code LIKE '%$keyword%') AND status='".$view."'";
        }
    } else {
        $criteria .= " AND status='".$view."'";
    }
    if (isset($show_only_current)) {
        $criteria .= ' AND checked_by=\''.$_SESSION['realname'].'\'';
    }

    // set criteria
    $datagrid->setSQLCriteria($criteria);

    // set table and table header attributes
    $datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
    $datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    // set delete proccess URL
    $datagrid->delete_URL = $_SERVER['PHP_SELF'];
    $datagrid->column_width = array('10%', '60%', '10%', '10%', '10%');
    $datagrid->disableSort('Current Status');

    // put the result into variables
    $datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, false);
    if (isset($_GET['keywords']) AND $_GET['keywords']) {
        $msg = str_replace('{result->num_rows}', $datagrid->num_rows, lang_sys_common_search_result_info);
        echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
    }

    echo $datagrid_result;
    /* main content end */
}
?>
