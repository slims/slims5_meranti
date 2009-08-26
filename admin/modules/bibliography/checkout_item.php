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

/* Checkout item list */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging_ajax.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.lang_sys_common_unauthorized.'</div>');
}
/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner itemOutIcon">
    <?php echo lang_mod_biblio_item_checkout; ?>
    <hr />
    <form name="search" action="blank.html" target="blindSubmit" onsubmit="$('doSearch').click();" id="search" method="get" style="display: inline;"><?php echo lang_sys_common_form_search_field; ?> :
    <input type="text" name="keywords" size="30" />
    <input type="button" id="doSearch" onclick="javascript: setContent('mainContent', '<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/checkout_item.php?' + $('search').serialize(), 'post');" value="<?php echo lang_sys_common_form_search; ?>" class="button" />
    </form>
</div>
</fieldset>
<?php
/* ITEM LIST */
// table spec
$table_spec = 'loan AS l
    LEFT JOIN member AS m ON l.member_id=m.member_id
    LEFT JOIN item AS i ON l.item_code=i.item_code
    LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id';

// create datagrid
$datagrid = new simbio_datagrid();
$datagrid->setSQLColumn("i.item_code AS '".lang_mod_circ_tblheader_item_code."'",
    "m.member_id AS '".lang_mod_circ_field_member_id."'",
    "b.title AS '".lang_mod_circ_tblheader_title."'",
    "l.loan_date AS '".lang_mod_circ_tblheader_loan_date."'",
    "l.due_date AS '".lang_mod_circ_tblheader_due_date."'");
$datagrid->setSQLorder("l.loan_date DESC");

// change the record order
if (isset($_GET['fld']) AND isset($_GET['dir'])) {
    $datagrid->setSQLorder("'".urldecode($_GET['fld'])."' ".$dbs->escape_string($_GET['dir']));
}

$checkout_criteria = ' (l.is_lent=1 AND l.is_return=0) ';

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
        $datagrid->setSQLCriteria($checkout_criteria.' AND '.$concat_sql);
    } else {
        $datagrid->setSQLCriteria($checkout_criteria." AND (b.title LIKE '%$keyword%' OR i.item_code LIKE '%$keyword%')");
    }
} else {
    $datagrid->setSQLCriteria($checkout_criteria);
}

// set table and table header attributes
$datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';

// set column width
$datagrid->column_width = array(0 => '12%', 1 => '12%', 2 => '50%');

// put the result into variables
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, false);
if (isset($_GET['keywords']) AND $_GET['keywords']) {
    echo '<div class="infoBox">';
    $msg = str_replace('{result->num_rows}', $datagrid->num_rows, lang_sys_common_search_result_info);
    echo $msg.' : "'.$_GET['keywords'].'"</div>';
}

echo $datagrid_result;
/* main content end */
?>
