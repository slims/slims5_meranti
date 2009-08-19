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

/* Report By Titles */

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

$page_title = 'Titles Report';
$reportView = false;
$num_recs_show = 20;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

if (!$reportView) {
?>
    <!-- filter -->
    <fieldset style="margin-bottom: 3px;">
    <legend style="font-weight: bold">TITLE LIST - Report Filter</legend>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="reportView">
    <div id="filterForm">
        <div class="divRow">
            <div class="divRowLabel">Title/ISBN</div>
            <div class="divRowContent">
            <?php echo simbio_form_element::textField('text', 'title', '', 'style="width: 50%"'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Author</div>
            <div class="divRowContent">
            <?php echo simbio_form_element::textField('text', 'author', '', 'style="width: 50%"'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Classification</div>
            <div class="divRowContent">
            <?php echo simbio_form_element::textField('text', 'class', '', 'style="width: 50%"'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">GMD</div>
            <div class="divRowContent">
            <?php
            $gmd_q = $dbs->query('SELECT gmd_id, gmd_name FROM mst_gmd');
            $gmd_options[] = array('0', 'All');
            while ($gmd_d = $gmd_q->fetch_row()) {
                $gmd_options[] = array($gmd_d[0], $gmd_d[1]);
            }
            echo simbio_form_element::selectList('gmd[]', $gmd_options, '','multiple="multiple" size="5"');
            ?> Press Shift or Alt to select more than one choice
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Language</div>
            <div class="divRowContent">
            <?php
            $lang_q = $dbs->query('SELECT language_id, language_name FROM mst_language');
            $lang_options = array();
            $lang_options[] = array('0', 'All');
            while ($lang_d = $lang_q->fetch_row()) {
                $lang_options[] = array($lang_d[0], $lang_d[1]);
            }
            echo simbio_form_element::selectList('language', $lang_options);
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
    // create datagrid
    $reportgrid = new report_datagrid();
    $reportgrid->setSQLColumn('b.biblio_id', 'b.title AS \'Title\'', 'COUNT(item_id) AS Copies',
        'b.isbn_issn AS \'ISBN/ISSN\'',
        'b.call_number AS \'Call Number\'');
    $reportgrid->setSQLorder('b.title ASC');
    $reportgrid->invisible_fields = array(0);

    // is there any search
    $criteria = 'bsub.biblio_id IS NOT NULL ';
    $outer_criteria = 'b.biblio_id > 0 ';
    if (isset($_GET['title']) AND !empty($_GET['title'])) {
        $keyword = $dbs->escape_string(trim($_GET['title']));
        $words = explode(' ', $keyword);
        if (count($words) > 1) {
            $concat_sql = ' AND (';
            foreach ($words as $word) {
                $concat_sql .= " (bsub.title LIKE '%$word%' OR bsub.isbn_issn LIKE '%$word%') AND";
            }
            // remove the last AND
            $concat_sql = substr_replace($concat_sql, '', -3);
            $concat_sql .= ') ';
            $criteria .= $concat_sql;
        } else {
            $criteria .= ' AND (bsub.title LIKE \'%'.$keyword.'%\' OR bsub.isbn_issn LIKE \'%'.$keyword.'%\')';
        }
    }
    if (isset($_GET['author']) AND !empty($_GET['author'])) {
        $author = $dbs->escape_string($_GET['author']);
        $criteria .= ' AND ma.author_name LIKE \'%'.$author.'%\'';
    }
    if (isset($_GET['class']) AND !empty($_GET['class'])) {
        $class = $dbs->escape_string($_GET['class']);
        $criteria .= ' AND bsub.classification LIKE \''.$class.'%\'';
    }
    if (isset($_GET['gmd']) AND !empty($_GET['gmd'])) {
        $gmd_IDs = '';
        foreach ($_GET['gmd'] as $id) {
            $id = (integer)$id;
            $gmd_IDs = "$id,";
        }
        $gmd_IDs = substr_replace($gmd_IDs, '', -1);
        $outer_criteria .= " AND b.gmd_id IN($gmd_IDs)";
    }
    if (isset($_GET['language']) AND !empty($_GET['language'])) {
        $language = $dbs->escape_string(trim($_GET['language']));
        $criteria .= ' AND bsub.language_id=\''.$language.'\'';
    }
    if (isset($_GET['location']) AND !empty($_GET['location'])) {
        $location = $dbs->escape_string(trim($_GET['location']));
        $outer_criteria .= 'i.location_id=\''.$location.'\'';
    }
    if (isset($_GET['recsEachPage'])) {
        $recsEachPage = (integer)$_GET['recsEachPage'];
        $num_recs_show = ($recsEachPage >= 20 && $recsEachPage <= 200)?$recsEachPage:$num_recs_show;
    }

    // subquery/view string
    $subquery_str = '(SELECT DISTINCT bsub.biblio_id, bsub.gmd_id, bsub.title, bsub.isbn_issn, bsub.call_number, bsub.classification, bsub.language_id
        FROM biblio AS bsub
        LEFT JOIN biblio_author AS ba ON bsub.biblio_id = ba.biblio_id
        LEFT JOIN mst_author AS ma ON ba.author_id = ma.author_id
        LEFT JOIN biblio_topic AS bt ON bsub.biblio_id = bt.biblio_id
        LEFT JOIN mst_topic AS mt ON bt.topic_id = mt.topic_id WHERE '.$criteria.')';

    // table spec
    $table_spec = $subquery_str.' AS b
        LEFT JOIN item AS i ON b.biblio_id=i.biblio_id';

    // set group by
    $reportgrid->sql_group_by = 'b.biblio_id';
    $reportgrid->setSQLCriteria($outer_criteria);

    // callback function to show title and authors
    function showTitleAuthors($obj_db, $array_data)
    {
        // author name query
        $_biblio_q = $obj_db->query('SELECT b.title, a.author_name FROM biblio AS b
            LEFT JOIN biblio_author AS ba ON b.biblio_id=ba.biblio_id
            LEFT JOIN mst_author AS a ON ba.author_id=a.author_id
            WHERE b.biblio_id='.$array_data[0]);
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
