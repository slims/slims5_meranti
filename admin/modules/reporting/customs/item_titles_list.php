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

/* Item List */

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

$page_title = 'Items/Copies Report';
$reportView = false;
$num_recs_show = 20;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

if (!$reportView) {
?>
    <!-- filter -->
    <fieldset style="margin-bottom: 3px;">
    <legend style="font-weight: bold">ITEM/TITLE LIST - Report Filter</legend>
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
            <div class="divRowLabel">Classification</div>
            <div class="divRowContent">
            <?php echo simbio_form_element::textField('text', 'class', '', 'style="width: 50%"'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Collection Type</div>
            <div class="divRowContent">
            <?php
            $coll_type_q = $dbs->query('SELECT coll_type_id, coll_type_name FROM mst_coll_type');
            $coll_type_options = array();
            $coll_type_options[] = array('0', 'All');
            while ($coll_type_d = $coll_type_q->fetch_row()) {
                $coll_type_options[] = array($coll_type_d[0], $coll_type_d[1]);
            }
            echo simbio_form_element::selectList('collType[]', $coll_type_options, '', 'multiple="multiple" size="5"');
            ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Status</div>
            <div class="divRowContent">
            <?php
            $status_q = $dbs->query('SELECT item_status_id, item_status_name FROM mst_item_status');
            $status_options = array();
            $status_options[] = array('0', 'All');
            while ($status_d = $status_q->fetch_row()) {
                $status_options[] = array($status_d[0], $status_d[1]);
            }
            echo simbio_form_element::selectList('status', $status_options);
            ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Location</div>
            <div class="divRowContent">
            <?php
            $loc_q = $dbs->query('SELECT location_id, location_name FROM mst_location');
            $loc_options = array();
            $loc_options[] = array('0', 'All');
            while ($loc_d = $loc_q->fetch_row()) {
                $loc_options[] = array($loc_d[0], $loc_d[1]);
            }
            echo simbio_form_element::selectList('location', $loc_options);
            ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Record each page</div>
            <div class="divRowContent"><input type="text" name="recsEachPage" size="3" maxlength="3" value="<?php echo $num_recs_show; ?>" /> Set between 20 and 200</div>
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
    $table_spec = 'item AS i
        LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
        LEFT JOIN mst_coll_type AS ct ON i.coll_type_id=ct.coll_type_id
        LEFT JOIN mst_item_status AS s ON i.item_status_id=s.item_status_id';

    // create datagrid
    $reportgrid = new report_datagrid();
    $reportgrid->setSQLColumn('i.item_code AS \'Item Code\'',
        'b.title AS \'Title\'',
        'ct.coll_type_name AS \'Collection Type\'',
        's.item_status_name AS \'Status\'',
        'b.call_number AS \'Call Number\'', 'i.biblio_id');
    $reportgrid->setSQLorder('b.title ASC');

    // is there any search
    $criteria = 'b.biblio_id IS NOT NULL ';
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
            $criteria .= ' AND (b.title LIKE \'%'.$keyword.'%\' OR b.isbn_issn LIKE \'%'.$keyword.'%\')';
        }
    }
    if (isset($_GET['itemCode']) AND !empty($_GET['itemCode'])) {
        $item_code = $dbs->escape_string(trim($_GET['itemCode']));
        $criteria .= ' AND i.item_code LIKE \'%'.$item_code.'%\'';
    }
    if (isset($_GET['collType']) AND !empty($_GET['collType'])) {
        $coll_type_IDs = '';
        foreach ($_GET['collType'] as $id) {
            $id = (integer)$id;
            $coll_type_IDs = "$id,";
        }
        $coll_type_IDs = substr_replace($coll_type_IDs, '', -1);
        $criteria .= " AND i.coll_type_id IN($coll_type_IDs)";
    }
    if (isset($_GET['status']) AND !empty($_GET['status'])) {
        $status = (integer)$_GET['status'];
        $criteria .= ' AND i.item_status_id='.$status;
    }
    if (isset($_GET['class']) AND !empty($_GET['class'])) {
        $class = $dbs->escape_string($_GET['class']);
        $criteria .= ' AND b.classification LIKE \''.$class.'%\'';
    }
    if (isset($_GET['location']) AND !empty($_GET['location'])) {
        $location = $dbs->escape_string(trim($_GET['location']));
        $criteria .= ' AND i.location_id=\''.$location.'\'';
    }
    if (isset($_GET['recsEachPage'])) {
        $recsEachPage = (integer)$_GET['recsEachPage'];
        $num_recs_show = ($recsEachPage >= 20 && $recsEachPage <= 200)?$recsEachPage:$num_recs_show;
    }

    $reportgrid->setSQLCriteria($criteria);

    // callback function to show title and authors
    function showTitleAuthors($obj_db, $array_data)
    {
        // author name query
        $_biblio_q = $obj_db->query('SELECT b.title, a.author_name FROM biblio AS b
            LEFT JOIN biblio_author AS ba ON b.biblio_id=ba.biblio_id
            LEFT JOIN mst_author AS a ON ba.author_id=a.author_id
            WHERE b.biblio_id='.$array_data[5]);
        $_authors = '';
        while ($_biblio_d = $_biblio_q->fetch_row()) {
            $_title = $_biblio_d[0];
            $_authors .= $_biblio_d[1].' - ';
        }
        $_authors = substr_replace($_authors, '', -3);
        $_output = $_title.'<br /><i>'.$_authors.'</i>'."\n";
        return $_output;
    }
    // modify column value
    $reportgrid->modifyColumnContent(1, 'callback{showTitleAuthors}');
    $reportgrid->invisible_fields = array(5);

    // set table and table header attributes
    $reportgrid->table_attr = 'align="center" id="dataListPrinted" cellpadding="3" cellspacing="1"';
    $reportgrid->table_header_attr = 'class="dataListHeaderPrinted"';

    // put the result into variables
    echo $reportgrid->createDataGrid($dbs, $table_spec, $num_recs_show);

    echo '<script type="text/javascript">'."\n";
    echo 'parent.$(\'pagingBox\').update(\''.str_replace(array("\n", "\r", "\t"), '', $reportgrid->paging_set).'\');'."\n";
    echo '</script>';

    $content = ob_get_clean();
    // include the page template
    require SENAYAN_BASE_DIR.'/admin/'.$sysconf['admin_template']['dir'].'/notemplate_page_tpl.php';
}
?>
