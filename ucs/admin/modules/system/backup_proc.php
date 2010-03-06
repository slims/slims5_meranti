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

// main system configuration
if (!defined('UCS_BASE_DIR')) {
    require '../../../ucsysconfig.inc.php';
}

// if backup process is invoked
if (isset($_POST['start'])) {
    // start the session
    require UCS_BASE_DIR.'admin/default/session.inc.php';
}

require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// privileges checking
$can_read = utility::havePrivilege('system', 'r');
$can_write = utility::havePrivilege('system', 'w');

if (!($can_read AND $can_write)) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
}
// if backup process is invoked
if (isset($_POST['start'])) {
    $output = '';
    // turn on implicit flush
    ob_implicit_flush();
    // checking if the binary can be executed
    exec($sysconf['mysqldump'], $outputs, $status);
    if ($status == BINARY_NOT_FOUND) {
        $output = 'The PATH for mysqldump program is NOT RIGHT!<br />Please check your configuration file again for mysqldump path vars';
    } else {
        // checking are the backup directory is exists and writable
        if (file_exists($sysconf['backup_dir']) AND is_writable($sysconf['backup_dir'])) {
            // time string to append to filename
            $time2append = (date('Ymd_His'));
            // execute the backup process
            exec($sysconf['mysqldump'].' -B '.DB_NAME.' --no-create-db --quick --user='.DB_USERNAME.' --password='.DB_PASSWORD.' > '.$sysconf['backup_dir'].DIRECTORY_SEPARATOR.'backup_'.$time2append.'.sql', $outputs, $status);
            if ($status == COMMAND_SUCCESS) {
                $data['user_id'] = 1;
                $data['backup_time'] = date('Y-m-d H:i"s');
                $data['backup_file'] = $dbs->escape_string($sysconf['backup_dir'].'backup_'.$time2append.'.sql');
                $output = 'Backup SUCCESSFUL, backup files saved to '.$sysconf['backup_dir'].'!'."<br />\n";

                if (!preg_match('@^WIN.*@i', PHP_OS)) {
                    // get current directory path
                    $curr_dir = getcwd();
                    // change current PHP working dir
                    @chdir($sysconf['backup_dir']);
                    // compress the backup using tar gz
                    exec('tar cvzf backup_'.$time2append.'.sql.tar.gz backup_'.$time2append.'.sql', $outputs, $status);
                    if ($status == COMMAND_SUCCESS) {
                        // delete the original file
                        @unlink($data['backup_file']);
                        $output .= "File is compressed using tar gz archive format <br />\n";
                        $data['backup_file'] = $dbs->escape_string($sysconf['backup_dir'].'backup_'.$time2append.'.sql.tar.gz');
                    }
                    // return to previous PHP working dir
                    @chdir($curr_dir);
                }

                // input log to database
                $sql_op = new simbio_dbop($dbs);
                $sql_op->insert('backup_log', $data);
            } else if ($status == COMMAND_FAILED) {
                $output = 'Backup FAILED! Wrong user or password to connect to database server!'."\n";
            }
        } else {
            $output = "Backup FAILED! The Backup directory is not exists or not writeable<br />\n";
            $output .= "Contact System Administrator for the right path of backup directory\n";
        }
    }

    echo '<div class="infoBox">'.$output.'</div>';
}

/* BACKUP LOG LIST */
// table spec
$table_spec = 'backup_log AS bl LEFT JOIN user AS u ON bl.user_id=u.user_id';

// create datagrid
$datagrid = new simbio_datagrid();
$datagrid->setSQLColumn('u.realname AS \'Backup Executor\'', 'bl.backup_time AS \'Backup Time\'', 'bl.backup_file AS \'Backup File Location\'');
$datagrid->setSQLorder('backup_time DESC');

// is there any search
if (isset($_GET['keywords']) AND $_GET['keywords']) {
   $keywords = $dbs->escape_string($_GET['keywords']);
   $datagrid->setSQLCriteria("bl.backup_time LIKE '%$keywords%' OR bl.backup_file LIKE '%$keywords%'");
}

// set table and table header attributes
$datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
// set delete proccess URL
$datagrid->delete_URL = $_SERVER['PHP_SELF'];

// put the result into variables
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, false);

echo $datagrid_result;
?>
