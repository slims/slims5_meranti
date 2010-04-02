<?php
/**
 * SLiMS Union Catalog server and node information
 *
 * Copyright (C) 2010  Hendro Wicaksono (hendrowicaksono@yahoo.com)
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

// be sure that this file not accessed directly
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die();
}

/**
 *
 * BEGIN SERVER AND NODES CONFIGURATION
 */
// server configuration
$sysconf['server'] = array(
    'id' => 'd13205a03e019e5926b910046b676c6c04f20363',
    'name' => $sysconf['library_name'],
    'subname' => $sysconf['library_subname'],
    'max_node_all' => 5, // maximum connection to server
    'max_node_conn' => 1 // maximum connection for each node
    );

// nodes configuration
$sysconf['node']['slims-node'] = array(
    'id' => 'slims-node', // node id (must be UNIQUE, lowercase and not containing any spaces!)
    'name' => 'SLiMS Library', // node name
    'password' => '2325f677e21c1613909c953eb03c57352259cc5d', // this hash created with SHA1 algoritm
    'baseurl' => 'http://localhost/senayan3-stable14', // node base URL
    'ip' => '' // IP address of node
    );

/*
 * Add other nodes configuration below
 */
// second node
// $sysconf['node']['slims-node2'] = array(
//     'id' => 'slims-node2',
//     'name' => 'SLiMS Library 2',
//     'password' => 'c8fed00eb2e87f1cee8e90ebbe870c190ac3848c',
//     'base_url' => 'http://perpustakaan.diknas.go.id',
//     'ip' => ''
//     );

?>
