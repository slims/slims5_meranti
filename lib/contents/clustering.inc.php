<?php
/**
 * Copyright (C) 2012  Arie Nugraha (dicarve@yahoo.com)
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

// Check if search clustering enabled
if (!$sysconf['enable_search_clustering']) {
  exit();
}

if (!isset($_GET['q'])) {
  echo "No Cluster Found!";
  exit();
} else {

  $cluster_limit = 30;

  require SIMBIO_BASE_DIR.'simbio_UTILS/simbio_tokenizecql.inc.php';
  require LIB_DIR.'biblio_list_model.inc.php';
  // index choice
  if ($sysconf['index']['type'] == 'index') {
    require LIB_DIR.'biblio_list_index.inc.php';
  } else if ($sysconf['index']['type'] == 'sphinx' && file_exists(LIB_DIR.'sphinx/sphinxapi.php')) {
    require LIB_DIR.'sphinx/sphinxapi.php';
    require LIB_DIR.'biblio_list_sphinx.inc.php';
    $sysconf['opac_result_num'] = (int)$sysconf['opac_result_num'];
  } else {
    require LIB_DIR.'biblio_list.inc.php';
  }

  // create biblio list object
  try {
    $biblio_list = new biblio_list($dbs, $sysconf['opac_result_num']);
  } catch (Exception $err) {
    die($err->getMessage());
  }

  $criteria = trim(strip_tags($_GET['q']));
  $sql_criteria = $biblio_list->setSQLcriteria($criteria);

  // cluster by GMD
  $gmd_cluster_q = $dbs->query('SELECT gmd.gmd_name AS `Cluster Name`, COUNT(biblio_id) AS `Cluster Count` FROM mst_gmd AS gmd
    LEFT JOIN biblio ON gmd.gmd_id=biblio.gmd_id WHERE '.$sql_criteria['sql_criteria'].' GROUP BY `Cluster Name` LIMIT '.$cluster_limit);
  echo '<h3 class="cluster-title">'.__('GMD').'</h3>'."\n";
  echo '<ul class="cluster-list">'."\n";
  while ($cluster_data = $gmd_cluster_q->fetch_assoc()) {
    echo '<li class="cluster-item"><a href="index.php?gmd='.urlencode($cluster_data['Cluster Name']).'&search=Search">'.$cluster_data['Cluster Name'].' ('.$cluster_data['Cluster Count'].')</a></li>'."\n";
  }
  echo '</ul>'."\n";

  // cluster by Collection type
  $coll_type_cluster_q = $dbs->query('SELECT ct.coll_type_name AS `Cluster Name`, COUNT(biblio.biblio_id) AS `Cluster Count` FROM mst_coll_type AS ct
    LEFT JOIN item AS i ON ct.coll_type_id=i.coll_type_id
    LEFT JOIN biblio ON i.biblio_id=biblio.biblio_id WHERE '.$sql_criteria['sql_criteria'].' GROUP BY `Cluster Name` LIMIT '.$cluster_limit);
  echo '<h3 class="cluster-title">'.__('GMD').'</h3>'."\n";
  echo '<ul class="cluster-list">'."\n";
  while ($cluster_data = $coll_type_cluster_q->fetch_assoc()) {
    echo '<li class="cluster-item"><a href="index.php?colltype='.urlencode($cluster_data['Cluster Name']).'&search=Search">'.$cluster_data['Cluster Name'].' ('.$cluster_data['Cluster Count'].')</a></li>'."\n";
  }
  echo '</ul>'."\n";

  // cluster by subject
  $subj_cluster_q = $dbs->query('SELECT t.topic AS `Cluster Name`, COUNT(bt.biblio_id) AS `Cluster Count` FROM mst_topic AS t
    LEFT JOIN biblio_topic AS bt ON t.topic_id=bt.topic_id
    LEFT JOIN biblio ON bt.biblio_id=biblio.biblio_id WHERE '.$sql_criteria['sql_criteria'].' GROUP BY `Cluster Name` LIMIT '.$cluster_limit);
  echo '<h3 class="cluster-title">'.__('Subject(s)').'</h3>'."\n";
  echo '<ul class="cluster-list">'."\n";
  while ($cluster_data = $subj_cluster_q->fetch_assoc()) {
    echo '<li class="cluster-item"><a href="index.php?subject='.urlencode('"'.$cluster_data['Cluster Name'].'"').'&search=Search">'.$cluster_data['Cluster Name'].' ('.$cluster_data['Cluster Count'].')</a></li>'."\n";
  }
  echo '</ul>'."\n";

  // cluster by author
  $auth_cluster_q = $dbs->query('SELECT a.author_name AS `Cluster Name`, COUNT(ba.biblio_id) AS `Cluster Count` FROM mst_author AS a
    LEFT JOIN biblio_author AS ba ON a.author_id=ba.author_id
    LEFT JOIN biblio ON ba.biblio_id=biblio.biblio_id WHERE '.$sql_criteria['sql_criteria'].' GROUP BY `Cluster Name` LIMIT '.$cluster_limit);
  echo '<h3 class="cluster-title">'.__('Author(s)').'</h3>'."\n";
  echo '<ul class="cluster-list">'."\n";
  while ($cluster_data = $auth_cluster_q->fetch_assoc()) {
    echo '<li class="cluster-item"><a href="index.php?author='.urlencode('"'.$cluster_data['Cluster Name'].'"').'&search=Search">'.$cluster_data['Cluster Name'].' ('.$cluster_data['Cluster Count'].')</a></li>'."\n";
  }
  echo '</ul>'."\n";
}

exit();