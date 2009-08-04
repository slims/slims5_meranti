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

/* Item List */

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_element.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require MODULES_BASE_DIR.'reporting/report_dbgrid.inc.php';

$page_title = 'Stock Take Lost Items';

$reportView = false;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

if (!$reportView) {
?>
    <!-- filter -->
    <fieldset style="margin-bottom: 3px;">
    <legend style="font-weight: bold">Current Stoke Take Report Filter</legend>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="reportView">
    <div id="filterForm">
    <div class="divRow">
        <div class="divRowLabel">Title/ISBN</div>
        <div class="divRowContent">
        <?php
        echo simbio_form_element::textField('text', 'title', '', 'style="width: 50%"');
        ?>
        </div>
    </div>
    <div class="divRow">
        <div class="divRowLabel">Item Code</div>
        <div class="divRowContent">
        <?php
        echo simbio_form_element::textField('text', 'itemCode', '', 'style="width: 50%"');
        ?>
        </div>
    </div>
    <div class="divRow">
        <div class="divRowLabel">Classification</div>
        <div class="divRowContent">
        <?php
        echo simbio_form_element::textField('text', 'class', '', 'style="width: 50%"');
        ?>
        </div>
    </div>
    <div class="divRow">
        <div class="divRowLabel">Collection Type</div>
        <div class="divRowContent">
        <?php
        $ct_q = $dbs->query('SELECT coll_type_name FROM mst_coll_type');
        $ct_options = array();
        $ct_options[] = array('0', 'All');
        while ($ct_d = $ct_q->fetch_row()) {
            $ct_options[] = array($ct_d[0], $ct_d[0]);
        }
        echo simbio_form_element::selectList('collType', $ct_options);
        ?>
        </div>
    </div>
    <div class="divRow">
        <div class="divRowLabel">Location</div>
        <div class="divRowContent">
        <?php
        $loc_q = $dbs->query('SELECT location_name FROM mst_location');
        $loc_options = array();
        $loc_options[] = array('0', 'All');
        while ($loc_d = $loc_q->fetch_row()) {
            $loc_options[] = array($loc_d[0], $loc_d[0]);
        }
        echo simbio_form_element::selectList('location', $loc_options);
        ?>
        </div>
    </div>
    <div style="padding-top: 10px; clear: both;">
    <input type="submit" name="applyFilter" value="Apply Filter" />
    <input type="button" name="moreFilter" value="Show More Filter Options" onclick="showHideTableRows('filterForm', 1, this, 'Show More Filter Options', 'Hide Filter Options')" />
    <input type="hidden" name="reportView" value="true" />
    </div>
    </form>
    </fieldset>
    <script type="text/javascript">hideRows('filterForm', 1);</script>
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
    $table_spec = 'stock_take_item AS i';

    // create datagrid
    $reportgrid = new report_datagrid();
    $reportgrid->setSQLColumn('item_code AS \'Item Code\'',
        'title AS \'Title\'',
        'classification AS \'Class\'',
        'coll_type_name AS \'Type\'',
        'call_number AS \'Call Number\'');
    $reportgrid->setSQLorder('title ASC');

    // is there any search
    $criteria = 'status=\'m\' ';
    if (isset($_GET['title']) AND !empty($_GET['title'])) {
        $keyword = $dbs->escape_string(trim($_GET['title']));
        $words = explode(' ', $keyword);
        if (count($words) > 1) {
            $concat_sql = ' AND (';
            foreach ($words as $word) {
                $concat_sql .= " (b.title LIKE '%$word%' OR b.isbn_issn LIKE '%$word%') AND";
            }
            // remove the last AND
            $concat_sql = substr_replace($concat_sql, '', -3);
            $concat_sql .= ') ';
            $criteria .= $concat_sql;
        } else {
            $criteria .= ' AND (title LIKE \'%'.$keyword.'%\')';
        }
    }
    if (isset($_GET['itemCode']) AND !empty($_GET['itemCode'])) {
        $item_code = $dbs->escape_string(trim($_GET['itemCode']));
        $criteria .= ' AND item_code LIKE \'%'.$item_code.'%\'';
    }
    if (isset($_GET['class']) AND !empty($_GET['class'])) {
        $class = $dbs->escape_string($_GET['class']);
        $criteria .= ' AND classification LIKE \''.$class.'%\'';
    }
    if (isset($_GET['collType']) AND !empty($_GET['collType'])) {
        $collType = $dbs->escape_string(trim($_GET['collType']));
        $criteria .= ' AND coll_type_name=\''.$collType.'\'';
    }
    if (isset($_GET['location']) AND !empty($_GET['location'])) {
        $location = $dbs->escape_string(trim($_GET['location']));
        $criteria .= ' AND location_name=\''.$location.'\'';
    }
    $reportgrid->setSQLCriteria($criteria);

    // set table and table header attributes
    $reportgrid->table_attr = 'align="center" id="dataListPrinted" cellpadding="3" cellspacing="1"';
    $reportgrid->table_header_attr = 'class="dataListHeaderPrinted"';

    // put the result into variables
    echo $reportgrid->createDataGrid($dbs, $table_spec, 50);

    echo '<script type="text/javascript">'."\n";
    echo 'parent.$(\'pagingBox\').update(\''.str_replace(array("\n", "\r", "\t"), '', $reportgrid->paging_set).'\');'."\n";
    echo '</script>';

    $content = ob_get_clean();
    // include the page template
    require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
}
?>
