<?php
/**
 * Copyright (C) 2010  Wardiyono (wynerst@gmail.com), Arie Nugraha (dicarve@yahoo.com)
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

/* Biblio Index Management section */

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';
require MODULES_BASE_DIR.'system/biblio_indexer.inc.php';

// privileges checking
$can_read = utility::havePrivilege('bibliography', 'r');
$can_write = utility::havePrivilege('bibliography', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
}

/* main content */
if (isset($_POST['detail']) OR (isset($_GET['action']) AND $_GET['action'] == 'detail')) {
    if (!($can_read AND $can_write)) {
        die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
    }

	/* empty table */
	if ($_GET['detail'] == 'empty') {
		$indexer = new biblio_indexer($dbs);
		$empty = $indexer->emptyingIndex();
		if ($empty) {
			$message = __('Index table truncated!');
		} else {
			$message = __('Index table FAILED to truncated, probably because of database query error!');
		}
		echo '<div class="infoBox">'.$message.'</div>'."\n";
		exit();
	}

	/* Update table */
	if ($_GET['detail'] == 'update') {
		set_time_limit(0);
		$indexer = new biblio_indexer($dbs);
		$indexer->updateFullIndex();
        $finish_minutes = $indexer->indexing_time/60;
        $finish_sec = $indexer->indexing_time%60;
		// message
		$message = sprintf(__('<strong>%d</strong> records (from total of <strong>%d</strong>) re-indexed. Finished in %d minutes %d second(s)'), $indexer->indexed, $indexer->total_records, $finish_minutes, $finish_sec);
		if ($indexer->failed) {
			$message = 	'<div style="color: #f00;">'.sprintf(__('<strong>%d</strong> index records failed to indexed. The IDs are: %s'), count($indexer->failed), implode(', ', $indexer->failed)).'</div>';
		}
		echo '<div class="infoBox">'.$message.'</div>'."\n";
	}

	/* re-create index table */
	if ($_GET['detail'] == 'reindex') {
		set_time_limit(0);
		$bib_sql = 'SELECT COUNT(*) FROM search_biblio';
		$rec_bib_q = $dbs->query($bib_sql);
		$rec_bib_d = $rec_bib_q->fetch_row();
		if ($rec_bib_d[0] > 0) {
			$message = __('Please empty the Index first before re-creating the Index');
			echo '<div class="errorBox">'.$message.'</div>'."\n";
		} else {
			$indexer = new biblio_indexer($dbs);
			$indexer->createFullIndex(false);
			$finish_minutes = $indexer->indexing_time/60;
			$finish_sec = $indexer->indexing_time%60;
			// message
			$message = sprintf(__('<strong>%d</strong> records (from total of <strong>%d</strong>) re-indexed. Finished in %d second(s)'), $indexer->indexed, $indexer->total_records, $finish_minutes, $finish_sec);
			if ($indexer->failed) {
				$message = 	'<div style="color: #f00;">'.sprintf(__('<strong>%d</strong> index records failed to indexed. The IDs are: %s'), count($indexer->failed), implode(', ', $indexer->failed)).'</div>';
			}
			echo '<div class="infoBox">'.$message.'</div>'."\n";
		}
	}
  exit();
} else {
?>
<fieldset class="menuBox">
<div class="menuBoxInner systemIcon">
    <?php echo strtoupper(__('Bibliographic Index')); ?>
	<div style="font-weight: normal">Bibliographic Index will speed up catalog search</div>
	<hr />
	<a href="<?php echo MODULES_WEB_ROOT_DIR; ?>system/biblio_indexes.php?action=detail&detail=empty" class="headerText2"><?php echo __('Emptying Index'); ?></a>
    &nbsp; <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>system/biblio_indexes.php?action=detail&detail=reindex" class="headerText2"><?php echo __('Re-create Index'); ?></a>
    &nbsp; <a href="<?php echo MODULES_WEB_ROOT_DIR; ?>system/biblio_indexes.php?action=detail&detail=update" class="headerText2"><?php echo __('Update Index'); ?></a>
</div>
</fieldset>
<?php
echo '<div class="infoBox">'."\n";
// Index info
$rec_bib_q = $dbs->query('SELECT COUNT(*) FROM biblio');
$rec_bib_d = $rec_bib_q->fetch_row();
$bib_total = $rec_bib_d[0];
$idx_bib_q = $dbs->query('SELECT COUNT(*) FROM search_biblio');
$idx_bib_d = $idx_bib_q->fetch_row();
$idx_total = $idx_bib_d[0];
$unidx_total = $bib_total - $idx_total;

echo '<div>Total data on biblio: ' . $bib_total . ' records.</div>';
echo '<div>Total indexed data: ' . $idx_total . ' records.</div>';
echo '<div>Unidexed data: ' . $unidx_total . ' records.</div>';
echo '</div>';
}
?>
