<?php
/**
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

/* Mass Node's Data Removal */

// main system configuration
require '../../../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';
require UCS_BASE_DIR.'admin/default/session_check.inc.php';

if (isset($_SESSION['formID']) && isset($_POST['nodeID']) && isset($_POST['removeAll'])) {
	// check form ID
	if ($_SESSION['formID'] === $_POST['formID']) {
		echo '<div class="errorBox">'.__('ERROR ON PROCESSING DATA REMOVAL REQUEST').'</div>';
		exit();
	}
	$node_ID = trim($dbs->escape_string(strip_tags($_POST['nodeID'])));
	if (isset($sysconf['node'][$node_ID])) {
		$node = $sysconf['node'][$node_ID];
		// remove all data
		$remove_q = $dbs->query('DELETE FROM biblio WHERE node_id=\''.$node_ID.'\'');
		$deleted = $dbs->affected_rows;
		if ($deleted) {
			// write to log
			utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'bibliography', $_SESSION['realname'].' remove all bibliographic of '.$node['name']);
			echo '<div class="infoBox">'.sprintf(__('%d records of %s removed succesfully from database'), $deleted, $node['name']).'</div>';
		}
	}
	// nullify form ID
	$_SESSION['formID'] = null;
	exit();
}

// nullify form ID
$_SESSION['formID'] = null;
?>
<fieldset class="menuBox">
<div class="menuBoxInner trashIcon">
    <?php echo strtoupper(__('Nodes Data Removal')); ?>
    <hr />
    <form name="search" action="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/nodes_removal.php" id="search" method="post" style="display: inline;"><?php echo __('Select Node'); ?> :
    <select name="node"><option value="0"><?php echo __('Select Node'); ?></option>
	<?php
	foreach ($sysconf['node'] as $id => $node) {
		echo '<option value="'.$id.'">'.$node['name'].'</option>';
	}
	?>
	</select>
    <input type="submit" name="doRemove" id="doRemove" value="<?php echo __('Remove All Selected Node\'s Data'); ?>" class="button" />
    </form>
</div>
</fieldset>
<?php

// nodes removal confirmation
if (isset($_POST['node']) && isset($_POST['doRemove'])) {
	$node_ID = trim($dbs->escape_string(strip_tags($_POST['node'])));
	if (isset($sysconf['node'][$node_ID])) {
		$node = $sysconf['node'][$node_ID];
		$node_data_num_q = $dbs->query('SELECT COUNT(*) FROM biblio WHERE node_id=\''.$node_ID.'\'');
		$node_data_num_d = $node_data_num_q->fetch_row();
		$node_data_num = $node_data_num_d[0];
		if ($node_data_num > 0) {
			// generate random number ID
			$_SESSION['formID'] = mt_rand();
			?>
			<fieldset class="menuBox">
			<div class="menuBoxInner errorIcon">
				<form name="removeNodeData" action="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/nodes_removal.php" id="removeNodeData" method="post">
				<strong style="color: #FF0000;">
				<?php echo sprintf(__('There is %d records found.<br /> Are you sure to REMOVE ALL DATA of %s node? Once it done there is no way you can undo this action!'), $node_data_num, $node['name']); ?>
				</strong>
				<div>
				<input type="hidden" name="nodeID" value="<?php echo $node_ID; ?>" />
				<input type="hidden" name="formID" value="<?php echo $_SESSION['formID']; ?>" />
				<input type="submit" name="removeAll" id="removeAll" value="<?php echo __('I\'m Very Sure to Remove ALL DATA'); ?>" class="button" style="color: #FF0000;" />
				&nbsp; <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>bibliography/nodes_removal.php"><?php echo __('CANCEL'); ?></a>
				</div>
				</form>
			</div>
			</fieldset>
			<?php
		} else {
			echo '<div class="errorBox">'.sprintf(__('Node %s doesn\'t have any record to remove!'), $node['name']).'</div>';
		}
	} else {
		echo '<div class="errorBox">'.__('Node Undefined on server!').'</div>';
	}
}
?>
