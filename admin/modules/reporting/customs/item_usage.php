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

/* Item Usage Statistic */

// main system configuration
require '../../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
// privileges checking
$can_read = utility::havePrivilege('reporting', 'r');
$can_write = utility::havePrivilege('reporting', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.lang_sys_common_no_privilage.'</div>');
}

require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_element.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require MODULES_BASE_DIR.'reporting/report_dbgrid.inc.php';

$page_title = 'Item Usage Report';
$reportView = false;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

if (!$reportView) {
?>
    <!-- filter -->
    <fieldset style="margin-bottom: 3px;">
    <legend style="font-weight: bold">ITEM USAGE STATISTIC - Report Filter</legend>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="reportView">
    <div id="filterForm">
        <div class="divRow">
            <div class="divRowLabel">Title/ISBN</div>
            <div class="divRowContent">
            <?php echo simbio_form_element::textField('text', 'title', '', 'style="width: 50%"'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Item Code</div>
            <div class="divRowContent">
            <?php echo simbio_form_element::textField('text', 'itemCode', '', 'style="width: 50%"'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Year</div>
            <div class="divRowContent">
            <?php
            $current_year = date('Y');
            $year_options = array();
            for ($y = $current_year; $y > 1999; $y--) {
                $year_options[] = array($y, $y);
            }
            echo simbio_form_element::selectList('year', $year_options, $current_year-1);
            ?>
            </div>
        </div>
    </div>
    <div style="padding-top: 10px; clear: both;">
    <input type="submit" name="applyFilter" value="Apply Filter" />
    <input type="hidden" name="reportView" value="true" />
    </div>
    </form>
    </fieldset>
    <!-- filter end -->
    <div class="dataListHeader" style="height: 35px;">
    <input type="button" value="Print Current Page" style="margin-top: 9px; margin-left: 5px; margin-right: 5px;"
    onclick="javascript: reportView.print();" />
    &nbsp;<span id="pagingBox">&nbsp;</span></div>
    <iframe name="reportView" src="<?php echo $_SERVER['PHP_SELF'].'?reportView=true'; ?>" frameborder="0" style="width: 100%; height: 500px;"></iframe>
<?php
} else {
    ob_start();
    // table spec
    $table_spec = 'item AS i
        LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id';

    // create datagrid
    $reportgrid = new report_datagrid();
    $reportgrid->setSQLColumn('i.item_code AS \'Item Code\'',
        'b.title AS \'Title\'',
        '\'01\' AS \'Jan\'',
        '\'02\' AS \'Feb\'',
        '\'03\' AS \'Mar\'',
        '\'04\' AS \'Apr\'',
        '\'05\' AS \'May\'',
        '\'06\' AS \'Jun\'',
        '\'07\' AS \'Jul\'',
        '\'08\' AS \'Aug\'',
        '\'09\' AS \'Sep\'',
        '\'10\' AS \'Oct\'',
        '\'11\' AS \'Nov\'',
        '\'12\' AS \'Dec\''
        );
    $reportgrid->setSQLorder('b.title ASC');

    // is there any search
    $criteria = 'b.biblio_id IS NOT NULL ';
    if (isset($_GET['title']) AND !empty($_GET['title'])) {
        $keyword = $dbs->escape_string(trim($_GET['title']));
        $words = explode(' ', $keyword);
        if (count($words) > 1) {
            $concat_sql = ' AND (';
            foreach ($words as $word) {
                $concat_sql .= " (b.title LIKE '%$word%' OR b.isbn_issn LIKE '$word%') AND";
            }
            // remove the last AND
            $concat_sql = substr_replace($concat_sql, '', -3);
            $concat_sql .= ') ';
            $criteria .= $concat_sql;
        } else {
            $criteria .= ' AND (b.title LIKE \'%'.$keyword.'%\' OR b.isbn_issn LIKE \''.$keyword.'%\')';
        }
    }
    if (isset($_GET['itemCode']) AND !empty($_GET['itemCode'])) {
        $item_code = $dbs->escape_string(trim($_GET['itemCode']));
        $criteria .= ' AND (i.item_code LIKE \'%'.$item_code.'%\')';
    }
    if (isset($_GET['year']) AND !empty($_GET['year'])) {
        $selected_year = (integer)$_GET['year'];
    } else {
        $selected_year = date('Y')-1;
    }
    $reportgrid->setSQLCriteria($criteria);

    // callback function to show overdued list
    function showUsage($obj_db, $array_data, $int_current_field_num)
    {
        global $selected_year;
        $_usage_q = $obj_db->query('SELECT COUNT(*) FROM loan AS l
            WHERE l.item_code=\''.$array_data[0].'\' AND l.loan_date LIKE \''.$selected_year.'-'.$array_data[$int_current_field_num].'%\'');
        $_usage_d = $_usage_q->fetch_row();
        return ($_usage_d[0]=='0')?'<span style="color: #ff0000;">0</span>':'<strong>'.$_usage_d[0].'</strong>';
    }
    // modify column value
    $reportgrid->modifyColumnContent(2, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(3, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(4, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(5, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(6, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(7, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(8, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(9, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(10, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(11, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(12, 'callback{showUsage}');
    $reportgrid->modifyColumnContent(13, 'callback{showUsage}');

    // no sort column
    $reportgrid->disableSort('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

    // set table and table header attributes
    $reportgrid->table_attr = 'align="center" id="dataListPrinted" cellpadding="3" cellspacing="1"';
    $reportgrid->table_header_attr = 'class="dataListHeaderPrinted"';

    // put the result into variables
    echo $reportgrid->createDataGrid($dbs, $table_spec, 20);

    echo '<script type="text/javascript">'."\n";
    echo 'parent.$(\'pagingBox\').update(\''.str_replace(array("\n", "\r", "\t"), '', $reportgrid->paging_set).'\');'."\n";
    echo '</script>';

    $content = ob_get_clean();
    // include the page template
    require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
}
?>
