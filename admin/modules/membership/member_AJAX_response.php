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

sleep(1);
require '../../../sysconfig.inc.php';

header('Content-type: text/javascript');
// get search value
if (isset($_POST['inputSearchVal'])) {
    $searchVal = $dbs->escape_string(urldecode(trim($_POST['inputSearchVal'])));
} else {
    exit();
}
// query to database
$member_q = $dbs->query("SELECT member_id, member_name
    FROM member WHERE member_id LIKE '%$searchVal%' OR member_name LIKE '%$searchVal%' LIMIT 5");
if ($member_q->num_rows < 1) {
    exit('NO DATA FOUND');
}
$json_array = array();
// loop data
while ($member_d = $member_q->fetch_row()) {
    $json_array[] = $member_d[0].' &lt;'.$member_d[1].'&gt;';
}
// encode to JSON array
if (!function_exists('json_encode')) {
    die('ERROR! JSON library is not installed in PHP');
}
echo json_encode($json_array);
?>
