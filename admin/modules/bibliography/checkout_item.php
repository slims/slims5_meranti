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

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You are not authorized to view this section').'</div>');
}
/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner itemOutIcon">
    <?php echo __('Checkout Items'); ?>
    <hr />
    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/checkout_item.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" size="30" />
    <input type="submit" id="doSearch" class="button" />
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
$datagrid->setSQLColumn("i.item_code AS '".__('Item Code')."'",
    "m.member_id AS '".__('Member ID')."'",
    "b.title AS '".__('Title')."'",
    "l.loan_date AS '".__('Loan Date')."'",
    "l.due_date AS '".__('Due Date')."'");
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
    $msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
    echo $msg.' : "'.$_GET['keywords'].'"</div>';
}

echo $datagrid_result;
/* main content end */
?>
