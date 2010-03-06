<?php
/**
 *
 * Copyright (C) 2010  Arie Nugraha (dicarve@yahoo.com)
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

/* Nodes Poll Viewer */

// main system configuration
require '../../../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';
require UCS_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require INC_DIR.'ucs_nodes_poll.inc.php';

// privileges checking
$can_read = utility::havePrivilege('system', 'r');
$can_write = utility::havePrivilege('system', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
}

// log data clearance action
if (isset($_POST['clearPoll']) AND $can_write AND $_SESSION['uid'] == 1) {
    ucs_nodes_poll::clear_poll($dbs);
    utility::jsAlert(__('Nodes poll cleared!'));
    echo '<script type="text/javascript">parent.setContent(\'mainContent\', \''.MODULES_WEB_ROOT_DIR.'system/nodes_poll.php\', \'get\');</script>';
    exit();
}

/* search form */
?>
<fieldset class="menuBox">
<div class="menuBoxInner nodesIcon">
    <?php echo strtoupper(__('NODES POLL'));?> -
    <?php if ($_SESSION['uid'] == 1) { ?>
    <a href="#" onclick="confSubmit('clearPollForm', '<?php echo __('Are you SURE to completely clear nodes poll!'); ?>')" class="notAJAX headerText2" style="color: red;"><?php echo __('CLEAR ALL NODES POLL'); ?></a>
    <?php } ?>
    <hr />
    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>system/nodes_poll.php" id="search" method="get" style="display: inline;"><?php echo __('Search'); ?> :
    <input type="text" name="keywords" size="30" />
    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button" />
    </form>
    <!-- POLL CLEARANCE FORM -->
    <?php if ($_SESSION['uid'] == 1) { ?>
    <form action="<?php echo MODULES_WEB_ROOT_DIR; ?>system/nodes_poll.php" id="clearPollForm" target="blindSubmit" method="post" style="display: inline;"><input type="hidden" name="clearPoll" value="true" /></form>
    <?php } ?>
    <!-- POLL CLEARANCE FORM END -->
</div>
</fieldset>
<?php
/* search form end */
/* NODES POLL LIST */
// table spec
$table_spec = 'nodes_poll AS npl';

function showStatus($obj_db, $array_data) {
    if ($array_data[4] == 1) {
        return '<span style="font-weight: bold;" class="isOnline">ONLINE</span>';
    }
    return '<span class="isOffline">Offline</span>';
}

// create datagrid
$datagrid = new simbio_datagrid();
$datagrid->setSQLColumn('node_id AS \''.__('Node').'\'',
    'node_ip AS \''.__('IP Address').'\'',
    'node_poll_time AS \''.__('Request Start').'\'',
    'node_poll_end AS \''.__('Request End').'\'',
    'is_online AS \''.__('Status').'\'');
$datagrid->setSQLorder('node_poll_time DESC');
// modify column value
$datagrid->modifyColumnContent(4, 'callback{showStatus}');

// is there any search
if (isset($_GET['keywords']) AND $_GET['keywords']) {
    $keyword = $dbs->escape_string(trim($_GET['keywords']));
    $words = explode(' ', $keyword);
    if (count($words) > 1) {
        $concat_sql = ' (';
        foreach ($words as $word) {
            $concat_sql .= " (node_id LIKE '%$word%' OR node_poll_time LIKE '%$word%') AND";
        }
        // remove the last AND
        $concat_sql = substr_replace($concat_sql, '', -3);
        $concat_sql .= ') ';
        $datagrid->setSQLCriteria($concat_sql);
    } else {
        $datagrid->setSQLCriteria("node_id LIKE '%$keyword%' OR node_poll_time LIKE '%$keyword%'");
    }
}

// set table and table header attributes
$datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
// set delete proccess URL
$datagrid->delete_URL = $_SERVER['PHP_SELF'];

// put the result into variables
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 50, false);
if (isset($_GET['keywords']) AND $_GET['keywords']) {
    $msg = str_replace('{result->num_rows}', $datagrid->num_rows, __('Found <strong>{result->num_rows}</strong> from your keywords')); //mfc
    echo '<div class="infoBox">'.$msg.' : "'.$_GET['keywords'].'"</div>';
}

echo $datagrid_result;
/* main content end */
?>
