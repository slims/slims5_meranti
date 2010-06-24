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

// main system configuration
require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

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
		$rec_bib = $dbs->query('TRUNCATE TABLE `search_biblio`');
		$message = __('Index table truncated!');
		echo '<div class="infoBox">'.$message.'</div>'."\n";
		/* echo 'Indeks tabel dihapus'; */
	}

	/* Update table */
	if ($_GET['detail'] == 'update') {
		set_time_limit(0);
		/*	$rec_bib = $dbs->query('SELECT biblio_id FROM biblio'); /* to update */
		$bib_sql = 'SELECT b.biblio_id, b.title, b.publish_year, b.notes, b.series_title, g.gmd_name AS `gmd`
			FROM (biblio AS b LEFT JOIN mst_gmd AS g ON b.gmd_id = g.gmd_id) LEFT JOIN search_biblio as sb ON b.biblio_id = sb.biblio_id
			WHERE sb.biblio_id is NULL';
		$rec_bib = $dbs->query($bib_sql); /* to reindex from 0 */
		$r = 0;
		$success = 0;
		$failed = array();
		if ($rec_bib->num_rows > 0) {
			while($rb_id = $rec_bib->fetch_assoc()) {

				$data['biblio_id'] = $rb_id['biblio_id'];

				/* GMD , Title, Year  */
				$data['title'] = $rb_id['title'];
				$data['gmd'] = $rb_id['gmd'];
				$data['year'] = $rb_id['publish_year'];
				if ($rb_id['notes'] != '') {
					$data['notes'] = trim($dbs->escape_string(strip_tags($rb_id['notes'], '<br><p><div><span><i><em><strong><b><code>s')));
				}
				if ($rb_id['series_title'] != '') {
					$data['series'] = $rb_id['series_title'];
				}

				/* author  */
				$au_all = '';
				$au_sql = 'SELECT ba.biblio_id, ba.level, au.author_name AS `name`, au.authority_type AS `type`
					FROM biblio_author AS ba LEFT JOIN mst_author AS au ON ba.author_id = au.author_id
					WHERE (ba.biblio_id ='. $rb_id['biblio_id'] . ')';
				$au_id = $dbs->query($au_sql);
				while($rs_au = $au_id->fetch_assoc()) {
					$au_all .= $rs_au['name'] . '  ';
				}
				if ($au_all !='') {
					$au_all = substr($au_all,0,strlen($au_all)-2);
					$data['author'] = $au_all;
				}

				/* subject  */
				$topic_all = '';
				$topic_sql = 'SELECT bt.biblio_id, bt.level, tp.topic, tp.topic_type AS `type`
					FROM biblio_topic AS bt LEFT JOIN mst_topic AS tp ON bt.topic_id = tp.topic_id
					WHERE (bt.biblio_id ='. $rb_id['biblio_id'] . ')';
				$topic_id = $dbs->query($topic_sql);
				while ($rs_topic = $topic_id->fetch_assoc()) {
					$topic_all .= $rs_topic['topic'] . '  ';
				}
				if ($topic_all != '') {
					$topic_all = substr($topic_all,0,strlen($topic_all)-2);
					$data['topic'] = $topic_all;
				}

				/* location  */
				$loc_all = '';
				$loc_sql = 'SELECT i.biblio_id, l.location_name AS `name`
					FROM item AS i LEFT JOIN mst_location AS l ON i.location_id = l.location_id
					WHERE (i.biblio_id ='. $rb_id['biblio_id'] . ')';
				$loc_id = $dbs->query($loc_sql);
				while ($rs_loc = $loc_id->fetch_assoc()) {
					$loc_all .= $rs_loc['name'] . '  ';
				}
				if ($loc_all != '') {
					$loc_all = substr($loc_all,0,strlen($loc_all)-2);
					$data['location'] = $loc_all;
				}

				/*  Insert all variable  */
				$sql_op = new simbio_dbop($dbs);

				/* uncomment to update only */
				/*
					$update = $sql_op->update('search_biblio', $data, 'biblio_id='.$rb_id['biblio_id']);
					if ($update) {
						echo 'ID ' .$rb_id['biblio_id']. ' updated.<br />';
					} else {
						echo 'ID ' .$rb_id['biblio_id']. ' update FAILED.<br />';
					}
				*/

				/* print_r ($data); /* debug submited update data */
				if ($sql_op->insert('search_biblio', $data)) {
					$success++;
				} else {
					$failed[] = $rb_id['biblio_id'];
				}
				$r++;
			}
			// message
			$message = sprintf(__('<strong>%d</strong> index records (from total of <strong>%d</strong>) updated!'), $success, $r);
			if ($failed) {
				$message = 	'<div style="color: #f00;">'.sprintf(__('<strong>%d</strong> index records failed to update. The IDs are: %s'), count($failed), implode(',', $failed)).'</div>';
			}
			echo '<div class="infoBox">'.$message.'</div>'."\n";
		} else {
			$message = __('No records need to be updated');
			echo '<div class="errorBox">'.$message.'</div>'."\n";
		}
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
			$bib_sql = 'SELECT b.biblio_id, b.title, b.publish_year, b.notes, b.series_title, g.gmd_name AS `gmd`
				FROM biblio AS b LEFT JOIN mst_gmd AS g ON b.gmd_id = g.gmd_id';
			$rec_bib = $dbs->query($bib_sql); /* to reindex from 0 */
			$r = 0;
			$success = 0;
			$failed = array();
			while($rb_id = $rec_bib->fetch_assoc()) {
				$data['biblio_id'] = $rb_id['biblio_id'];

				/* GMD , Title, Year  */
				$data['title'] = $rb_id['title'];
				$data['gmd'] = $rb_id['gmd'];
				$data['year'] = $rb_id['publish_year'];
				if ($rb_id['notes'] != '') {
					$data['notes'] = trim($dbs->escape_string(strip_tags($rb_id['notes'], '<br><p><div><span><i><em><strong><b><code>s')));
				}
				if ($rb_id['series_title'] != '') {
					$data['series'] = $rb_id['series_title'];
				}

				/* author  */
				$au_all = '';
				$au_sql = 'SELECT ba.biblio_id, ba.level, au.author_name AS `name`, au.authority_type AS `type`
					FROM biblio_author AS ba LEFT JOIN mst_author AS au ON ba.author_id = au.author_id
					WHERE (ba.biblio_id ='. $rb_id['biblio_id'] . ')';
				$au_id = $dbs->query($au_sql);
				while($rs_au = $au_id->fetch_assoc()) {
					$au_all .= $rs_au['name'] . '  ';
				}
				if ($au_all !='') {
					$au_all = substr($au_all,0,strlen($au_all)-2);
					$data['author'] = $au_all;
				}

				/* subject  */
				$topic_all = '';
				$topic_sql = 'SELECT bt.biblio_id, bt.level, tp.topic, tp.topic_type AS `type`
					FROM biblio_topic AS bt LEFT JOIN mst_topic AS tp ON bt.topic_id = tp.topic_id
					WHERE (bt.biblio_id ='. $rb_id['biblio_id'] . ')';
				$topic_id = $dbs->query($topic_sql);
				while ($rs_topic = $topic_id->fetch_assoc()) {
					$topic_all .= $rs_topic['topic'] . '  ';
				}
				if ($topic_all != '') {
					$topic_all = substr($topic_all,0,strlen($topic_all)-2);
					$data['topic'] = $topic_all;
				}

				/* location  */
				$loc_all = '';
				$loc_sql = 'SELECT i.biblio_id, l.location_name AS `name`
					FROM item AS i LEFT JOIN mst_location AS l ON i.location_id = l.location_id
					WHERE (i.biblio_id ='. $rb_id['biblio_id'] . ')';
				$loc_id = $dbs->query($loc_sql);
				while ($rs_loc = $loc_id->fetch_assoc()) {
					$loc_all .= $rs_loc['name'] . '  ';
				}
				if ($loc_all != '') {
					$loc_all = substr($loc_all,0,strlen($loc_all)-2);
					$data['location'] = $loc_all;
				}

				/*  Insert all variable  */
				$sql_op = new simbio_dbop($dbs);

				/* uncomment to update only */
				/*
					$update = $sql_op->update('search_biblio', $data, 'biblio_id='.$rb_id['biblio_id']);
					if ($update) {
						echo 'ID ' .$rb_id['biblio_id']. ' updated.<br />';
					} else {
						echo 'ID ' .$rb_id['biblio_id']. ' update FAILED.<br />';
					}
				*/

				/* print_r ($data); /* debug submited update data */
				if ($sql_op->insert('search_biblio', $data)) {
					$success++;
				} else {
					$failed[] = $rb_id['biblio_id'];
				}
				$r++;
			}
			// message
			$message = sprintf(__('<strong>%d</strong> records (from total of <strong>%d</strong>) re-indexed!'), $success, $r);
			if ($failed) {
				$message = 	'<div style="color: #f00;">'.sprintf(__('<strong>%d</strong> index records failed to indexed. The IDs are: %s'), count($failed), implode(', ', $failed)).'</div>';
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
