<?php
/**
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

class ucs_nodes_poll {
	/**
	 * method to check node polling in server
	 * @param	object	$obj_db: database connection object
	 * @param	string	$str_node_name: node name to check
	 * @return	integer
	 */
	public static function check_node_poll($obj_db, $str_node_name) {
		$str_node_name = $obj_db->escape_string($str_node_name);
		$_q = $obj_db->query("SELECT * FROM nodes_poll WHERE node_id='$str_node_name' AND is_online=1 LIMIT 50");
		return $_q->num_rows;
	}


	/**
	 * method to check all node polling in server
	 * @param	object	$obj_db: database connection object
	 * @return	integer
	 */
	public static function check_poll($obj_db) {
		$_q = $obj_db->query("SELECT * FROM nodes_poll WHERE is_online=1 LIMIT 100");
		return $_q->num_rows;
	}


	/**
	 * clear server poll data
	 * @param	object	$obj_db: database connection object
	 * @param	string	$node_id: optional node id
	 * @return	void
	 */
	public static function clear_poll($obj_db, $node_id = '') {
		$node_id = trim($obj_db->escape_string($node_id));
		if (!$node_id) {
			$_q = $obj_db->query("UPDATE nodes_poll SET is_online=0");
			return;
		}
		$_q = $obj_db->query("UPDATE nodes_poll SET is_online=0, node_poll_end=NOW() WHERE node_id='$node_id'");
	}


	/**
	 * set node poll data
	 * @param	object	$obj_db: database connection object
	 * @param	string	$node_id: node id to set
	 * @return	void
	 */
	public static function set_node_poll($obj_db, $str_node_id, $str_node_ip) {
		$_q = $obj_db->query("INSERT INTO nodes_poll VALUES (NULL, '$str_node_id', '$str_node_ip', NOW(), NULL, 1)");
	}
}
?>
