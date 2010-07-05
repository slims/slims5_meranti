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

class biblio_indexer
{
	public $total_records = 0;
	public $indexed = 0;
	public $failed = array();
	public $errors = array();
	private $exclude = array();
	private $obj_db = false;

	public function __construct($obj_db) {
		$this->obj_db = $obj_db;
	}


	/**
	 * Creating full index database of bibliographic records
	 * @param	boolean		$bool_empty_first: Emptying current index first
	 * @return	void
	 */
	public function createFullIndex($bool_empty_first = false) {
		if ($bool_empty_first) {
			$this->emptyingIndex();
		}
		$bib_sql = 'SELECT biblio_id FROM biblio';
		// query
		$rec_bib = $this->obj_db->query($bib_sql);
		$r = 0;
		if ($rec_bib->num_rows > 0) {
			$this->total_records = $rec_bib->num_rows;
			while ($rb_id = $rec_bib->fetch_row()) {
				$biblio_id = $rb_id[0];
				$index = $this->makeIndex($biblio_id);
			}
		}
	}


	/**
	 * Emptying index table
	 * @return	boolean		true on success, false otherwise
	 */
	public function emptyingIndex() {
		@$this->obj_db->query('TRUNCATE TABLE `search_biblio`');
		if ($this->obj_db->errno) {
			$this->errors[] = $this->obj_db->error;
			return false;
		}
		return true;
	}


	/**
	 * Make index for one bibliographic record
	 * @param	int		$int_biblio_id: ID of biblio to index
	 * @return	boolean	false on Failed, true otherwise
	 */
	public function makeIndex($int_biblio_id) {
		$bib_sql = 'SELECT b.biblio_id, b.title, b.publish_year, b.notes, b.series_title, b.classification, b.spec_detail_info,
			g.gmd_name AS `gmd`, pb.publisher_name AS `publisher`, pl.place_name AS `publish_place`,
			lg.language_name AS `language`
			FROM biblio AS b
			LEFT JOIN mst_gmd AS g ON b.gmd_id = g.gmd_id
			LEFT JOIN mst_publisher AS pb ON b.publisher_id = pb.publisher_id
			LEFT JOIN mst_place AS pl ON b.publish_place_id = pl.place_id
			LEFT JOIN mst_language AS lg ON b.language_id = lg.language_id WHERE b.biblio_id='.$int_biblio_id;
		// query
		$rec_bib = $this->obj_db->query($bib_sql);

		if ($rec_bib->num_rows < 1) {
			return false;
		} else {
			$rb_id = $rec_bib->fetch_assoc();
		}

		$data['biblio_id'] = $int_biblio_id;

		/* GMD , Title, Year  */
		$data['title'] = $rb_id['title'];
		$data['gmd'] = $rb_id['gmd'];
		$data['publisher'] = $rb_id['publisher'];
		$data['publish_place'] = $rb_id['publish_place'];
		$data['language'] = $rb_id['language'];
		$data['year'] = $rb_id['publish_year'];
		$data['classification'] = $rb_id['classification'];
		$data['spec_detail_info'] = $rb_id['spec_detail_info'];
		if ($rb_id['notes'] != '') {
			$data['notes'] = trim($this->obj_db->escape_string(strip_tags($rb_id['notes'], '<br><p><div><span><i><em><strong><b><code>')));
		}
		if ($rb_id['series_title'] != '') {
			$data['series'] = $rb_id['series_title'];
		}

		/* author  */
		$au_all = '';
		$au_sql = 'SELECT ba.biblio_id, ba.level, au.author_name AS `name`, au.authority_type AS `type`
			FROM biblio_author AS ba LEFT JOIN mst_author AS au ON ba.author_id = au.author_id
			WHERE ba.biblio_id ='. $int_biblio_id;
		$au_id = $this->obj_db->query($au_sql);
		while($rs_au = $au_id->fetch_assoc()) {
			$au_all .= $rs_au['name'] . ' ';
		}
		if ($au_all !='') {
			$au_all = trim($au_all);
			$data['author'] = $au_all;
		}

		/* subject  */
		$topic_all = '';
		$topic_sql = 'SELECT bt.biblio_id, bt.level, tp.topic, tp.topic_type AS `type`
			FROM biblio_topic AS bt LEFT JOIN mst_topic AS tp ON bt.topic_id = tp.topic_id
			WHERE bt.biblio_id ='. $int_biblio_id;
		$topic_id = $this->obj_db->query($topic_sql);
		while ($rs_topic = $topic_id->fetch_assoc()) {
			$topic_all .= $rs_topic['topic'] . ' ';
		}
		if ($topic_all != '') {
			$topic_all = trim($topic_all);
			$data['topic'] = $topic_all;
		}

		/* location  */
		$loc_all = '';
		$loc_sql = 'SELECT i.biblio_id, l.location_name AS `name`
			FROM item AS i LEFT JOIN mst_location AS l ON i.location_id = l.location_id
			WHERE i.biblio_id ='. $int_biblio_id;
		$loc_id = $this->obj_db->query($loc_sql);
		while ($rs_loc = $loc_id->fetch_assoc()) {
			$loc_all .= $rs_loc['name'] . ' ';
		}
		if ($loc_all != '') {
			$loc_all = trim($loc_all);
			$data['location'] = $loc_all;
		}

		/* barcodes */
		$barcode_all = '';
		$barcode_sql = 'SELECT i.item_code FROM item AS i WHERE i.biblio_id ='. $int_biblio_id;
		$barcode_q = $this->obj_db->query($barcode_sql);
		while ($rs_barcode = $barcode_q->fetch_assoc()) {
			$barcode_all .= $rs_barcode['item_code'] . ' ';
		}
		if ($barcode_all != '') {
			$barcode_all = trim($barcode_all);
			$data['barcodes'] = $barcode_all;
		}

		/* collection types */
		$colltype_all = '';
		$colltype_sql = 'SELECT ct.coll_type_name AS `name`
			FROM item AS i LEFT JOIN mst_coll_type AS ct ON i.coll_type_id = ct.coll_type_id
			WHERE i.biblio_id ='. $int_biblio_id;
		$colltype_q = $this->obj_db->query($colltype_sql);
		while ($rs_colltype = $colltype_q->fetch_assoc()) {
			$colltype_all .= $rs_colltype['name'] . ' ';
		}
		if ($colltype_all != '') {
			$colltype_all = trim($colltype_all);
			$data['collection_types'] = $colltype_all;
		}

		/*  SQL operation object  */
		$sql_op = new simbio_dbop($this->obj_db);

		/*  Insert all variable  */
		if ($sql_op->insert('search_biblio', $data)) {
			$this->indexed++;
		} else {
			$this->failed[] = $int_biblio_id;
		}

		return true;
	}


	/**
	 * Update index
	 *
	 * @return	void
	 */
	public function updateFullIndex() {
		$bib_sql = 'SELECT b.biblio_id FROM biblio AS b
			LEFT JOIN search_biblio AS sb ON b.biblio_id = sb.biblio_id
			WHERE sb.biblio_id is NULL';
		// query
		$rec_bib = $this->obj_db->query($bib_sql);
		$r = 0;
		if ($rec_bib->num_rows > 0) {
			$this->total_records = $rec_bib->num_rows;
			while ($rb_id = $rec_bib->fetch_row()) {
				$biblio_id = $rb_id[0];
				$index = $this->makeIndex($biblio_id);
			}
		}
	}
}
?>
