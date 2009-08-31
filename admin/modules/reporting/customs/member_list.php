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

/* Library Member List */

// main system configuration
require '../../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
// privileges checking
$can_read = utility::havePrivilege('reporting', 'r');
$can_write = utility::havePrivilege('reporting', 'w');

if (!$can_read) {
    die('<div class="errorBox">'._('You don\'t have enough privileges to access this area!').'</div>');
}

require SIMBIO_BASE_DIR.'simbio_GUI/template_parser/simbio_template_parser.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_element.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require MODULES_BASE_DIR.'reporting/report_dbgrid.inc.php';

$page_title = 'Members Report';
$reportView = false;
$num_recs_show = 20;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

if (!$reportView) {
?>
    <!-- filter -->
    <fieldset style="margin-bottom: 3px;">
    <legend style="font-weight: bold"><?php echo strtoupper(_('Member List')); ?> - <?php echo _('Report Filter'); ?></legend>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="reportView">
    <div id="filterForm">
        <div class="divRow">
            <div class="divRowLabel"><?php echo _('Membership Type'); ?></div>
            <div class="divRowContent">
            <?php
            $mtype_q = $dbs->query('SELECT member_type_id, member_type_name FROM mst_member_type');
            $mtype_options = array();
            $mtype_options[] = array('0', _('ALL'));
            while ($mtype_d = $mtype_q->fetch_row()) {
                $mtype_options[] = array($mtype_d[0], $mtype_d[1]);
            }
            echo simbio_form_element::selectList('member_type', $mtype_options);
            ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel"><?php echo _('Member ID').'/'._('Member Name'); ?></div>
            <div class="divRowContent">
            <?php echo simbio_form_element::textField('text', 'id_name', '', 'style="width: 50%"'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel"><?php echo _('Gender'); ?></div>
            <div class="divRowContent">
            <?php
            $gender_chbox[0] = array('ALL', _('ALL'));
            $gender_chbox[1] = array('1', _('Male'));
            $gender_chbox[2] = array('0', _('Female'));
            echo simbio_form_element::radioButton('gender', $gender_chbox, 'ALL');
            ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel"><?php echo _('Address'); ?></div>
            <div class="divRowContent">
            <?php echo simbio_form_element::textField('text', 'address', '', 'style="width: 50%"'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel"><?php echo _('Register Date From'); ?></div>
            <div class="divRowContent">
            <?php echo simbio_form_element::dateField('startDate', '2000-01-01'); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel"><?php echo _('Register Date Until'); ?></div>
            <div class="divRowContent">
            <?php echo simbio_form_element::dateField('untilDate', date('Y-m-d')); ?>
            </div>
        </div>
        <div class="divRow">
            <div class="divRowLabel"><?php echo _('Record each page'); ?></div>
            <div class="divRowContent"><input type="text" name="recsEachPage" size="3" maxlength="3" value="<?php echo $num_recs_show; ?>" /> <?php echo _('Set between 20 and 200'); ?></div>
        </div>
    </div>
    <div style="padding-top: 10px; clear: both;">
    <input type="submit" name="applyFilter" value="<?php echo _('Apply Filter'); ?>" />
    <input type="button" name="moreFilter" value="<?php echo _('Show More Filter Options'); ?>" onclick="showHideTableRows('filterForm', 1, this, '<?php echo _('Show More Filter Options'); ?>', '<?php echo _('Hide Filter Options'); ?>')" />
    <input type="hidden" name="reportView" value="true" />
    </div>
    </form>
    </fieldset>
    <script type="text/javascript">hideRows('filterForm', 1);</script>
    <!-- filter end -->
    <div class="dataListHeader" style="height: 35px;">
    <input type="button" value="<?php echo _('Print Current Page'); ?>" style="margin-top: 9px; margin-left: 5px; margin-right: 5px;"
    onclick="javascript: reportView.print();" />
    &nbsp;<span id="pagingBox">&nbsp;</span></div>
    <iframe name="reportView" src="<?php echo $_SERVER['PHP_SELF'].'?reportView=true'; ?>" frameborder="0" style="width: 100%; height: 500px;"></iframe>
<?php
} else {
    ob_start();
    // table spec
    $table_spec = 'member AS m
        LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id';

    // create datagrid
    $reportgrid = new report_datagrid();
    $reportgrid->setSQLColumn('m.member_id AS \''._('Member ID').'\'',
        'm.member_name AS \''._('Member Name').'\'',
        'mt.member_type_name AS \''._('Membership Type').'\'');
    $reportgrid->setSQLorder('member_name ASC');

    // is there any search
    $criteria = 'm.member_id IS NOT NULL ';
    if (isset($_GET['member_type']) AND !empty($_GET['member_type'])) {
        $mtype = intval($_GET['member_type']);
        $criteria .= ' AND m.member_type_id='.$mtype;
    }
    if (isset($_GET['id_name']) AND !empty($_GET['id_name'])) {
        $id_name = $dbs->escape_string($_GET['id_name']);
        $criteria .= ' AND (m.member_id LIKE \'%'.$id_name.'%\' OR m.member_name LIKE \'%'.$id_name.'%\')';
    }
    if (isset($_GET['gender']) AND $_GET['gender'] != 'ALL') {
        $gender = intval($_GET['gender']);
        $criteria .= ' AND m.gender='.$gender;
    }
    if (isset($_GET['address']) AND !empty($_GET['address'])) {
        $address = $dbs->escape_string(trim($_GET['address']));
        $criteria .= ' AND m.member_address LIKE \'%'.$address.'%\'';
    }
    // register date
    if (isset($_GET['startDate']) AND isset($_GET['untilDate'])) {
        $criteria .= ' AND (TO_DAYS(m.register_date) BETWEEN TO_DAYS(\''.$_GET['startDate'].'\') AND
            TO_DAYS(\''.$_GET['untilDate'].'\'))';
    }
    if (isset($_GET['recsEachPage'])) {
        $recsEachPage = (integer)$_GET['recsEachPage'];
        $num_recs_show = ($recsEachPage >= 20 && $recsEachPage <= 200)?$recsEachPage:$num_recs_show;
    }
    $reportgrid->setSQLCriteria($criteria);

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
