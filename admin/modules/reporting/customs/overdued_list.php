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

/* Overdues Report */

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
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_element.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require MODULES_BASE_DIR.'reporting/report_dbgrid.inc.php';

$page_title = 'Overdued List Report';
$reportView = false;
$num_recs_show = 20;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

if (!$reportView) {
?>
    <!-- filter -->
    <fieldset style="margin-bottom: 3px;">
    <legend style="font-weight: bold">OVERDUED LIST - Report Filter</legend>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="reportView">
    <div id="filterForm">
        <div class="divRow">
            <div class="divRowLabel">Member ID/Member Name</div>
            <div class="divRowContent">
            <?php
            echo simbio_form_element::textField('text', 'id_name', '', 'style="width: 50%"');
            ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Loan Date From</div>
            <div class="divRowContent">
            <?php
            echo simbio_form_element::dateField('startDate', '2000-01-01');
            ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Loan Date Until</div>
            <div class="divRowContent">
            <?php
            echo simbio_form_element::dateField('untilDate', date('Y-m-d'));
            ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel">Record each page</div>
            <div class="divRowContent"><input type="text" name="recsEachPage" size="3" maxlength="3" value="<?php echo $num_recs_show; ?>" /> Set between 5 and 200</div>
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
    $table_spec = 'member AS m
        LEFT JOIN loan AS l ON m.member_id=l.member_id';

    // create datagrid
    $reportgrid = new report_datagrid();
    $reportgrid->setSQLColumn('m.member_id AS \'Member ID\'');
    $reportgrid->setSQLorder('l.due_date DESC');
    $reportgrid->sql_group_by = 'm.member_id';

    $overdue_criteria = ' (l.is_lent=1 AND l.is_return=0 AND TO_DAYS(due_date) < TO_DAYS(\''.date('Y-m-d').'\')) ';
    // is there any search
    if (isset($_GET['id_name']) AND $_GET['id_name']) {
        $keyword = $dbs->escape_string(trim($_GET['id_name']));
        $words = explode(' ', $keyword);
        if (count($words) > 1) {
            $concat_sql = ' (';
            foreach ($words as $word) {
                $concat_sql .= " (m.member_id LIKE '%$word%' OR m.member_name LIKE '%$word%') AND";
            }
            // remove the last AND
            $concat_sql = substr_replace($concat_sql, '', -3);
            $concat_sql .= ') ';
            $overdue_criteria .= ' AND '.$concat_sql;
        } else {
            $overdue_criteria .= " AND m.member_id LIKE '%$keyword%' OR m.member_name LIKE '%$keyword%'";
        }
    }
    // loan date
    if (isset($_GET['startYear']) AND isset($_GET['startMonth']) AND isset($_GET['startDate'])) {
        $date_criteria = ' AND (TO_DAYS(l.loan_date) BETWEEN TO_DAYS(\''.$_GET['startDate'].'\') AND
            TO_DAYS(\''.$_GET['untilDate'].'\'))';
        $overdue_criteria .= $date_criteria;
    }
    if (isset($_GET['recsEachPage'])) {
        $recsEachPage = (integer)$_GET['recsEachPage'];
        $num_recs_show = ($recsEachPage >= 5 && $recsEachPage <= 200)?$recsEachPage:$num_recs_show;
    }
    $reportgrid->setSQLCriteria($overdue_criteria);

    // set table and table header attributes
    $reportgrid->table_attr = 'align="center" id="dataListPrinted" cellpadding="5" cellspacing="0"';
    $reportgrid->table_header_attr = 'class="dataListHeaderPrinted"';
    $reportgrid->column_width = array('1' => '80%');

    // callback function to show overdued list
    function showOverduedList($obj_db, $array_data)
    {
        global $date_criteria;

        // member name
        $member_q = $obj_db->query('SELECT member_name, member_email, member_phone FROM member WHERE member_id=\''.$array_data[0].'\'');
        $member_d = $member_q->fetch_row();
        $member_name = $member_d[0];
        unset($member_q);

        $ovd_title_q = $obj_db->query('SELECT l.item_code, i.price, i.price_currency,
            b.title, l.loan_date,
            l.due_date, (TO_DAYS(DATE(NOW()))-TO_DAYS(due_date)) AS \'Overdue Days\'
            FROM loan AS l
                LEFT JOIN item AS i ON l.item_code=i.item_code
                LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
            WHERE (l.is_lent=1 AND l.is_return=0 AND TO_DAYS(due_date) < TO_DAYS(\''.date('Y-m-d').'\')) AND l.member_id=\''.$array_data[0].'\''.( !empty($date_criteria)?$date_criteria:'' ));
        $_buffer = '<div style="font-weight: bold; color: black; font-size: 10pt; margin-bottom: 3px;">'.$member_name.' ('.$array_data[0].')</div>';
        $_buffer .= '<div style="font-size: 10pt; margin-bottom: 3px;">E-mail : <a href="mailto:'.$member_d[1].'">'.$member_d[1].'</a> - Phone : '.$member_d[2].'</div>';
        $_buffer .= '<table width="100%" cellspacing="0">';
        while ($ovd_title_d = $ovd_title_q->fetch_assoc()) {
            $_buffer .= '<tr>';
            $_buffer .= '<td valign="top" width="10%">'.$ovd_title_d['item_code'].'</td>';
            $_buffer .= '<td valign="top" width="40%">'.$ovd_title_d['title'].'<div>Price : '.$ovd_title_d['price'].' '.$ovd_title_d['price_currency'].'</div></td>';
            $_buffer .= '<td width="20%">Overdue : '.$ovd_title_d['Overdue Days'].' day(s)</td>';
            $_buffer .= '<td width="30%">Loan Date : '.$ovd_title_d['loan_date'].' &nbsp; Due Date : '.$ovd_title_d['due_date'].'</td>';
            $_buffer .= '</tr>';
        }
        $_buffer .= '</table>';
        return $_buffer;
    }
    // modify column value
    $reportgrid->modifyColumnContent(0, 'callback{showOverduedList}');

    // attributes
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

