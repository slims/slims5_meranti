<?php
/**
 * SLiMS Union Catalog polling
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

require 'ucsysconfig.inc.php';
require 'ucserver.inc.php';
require LIB_DIR.'http_request.inc.php';

// create http request object
$http_request = new http_request();
$http_request->get_http_request();
// get http content
$referer = trim($http_request->headers('REFERER'));
$body = trim($http_request->body());

// sent HTTP header
header('Content-type: text/json');

// check content
if ($body) {
    // encode to PHP array
    $op = json_decode($body, true);
    if (function_exists('json_last_error')) {
        // Define the errors.
        $json_errors = array(
            JSON_ERROR_DEPTH => 'JSON error: The maximum stack depth has been exceeded',
            JSON_ERROR_CTRL_CHAR => 'JSON error: Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX => 'JSON error: Syntax error',
        );
        // get json error
        $json_error = json_last_error();
        if ($json_error) {
            die(json_encode(array('status' => 'JSON_ERROR', 'message' => $json_errors[$json_error])));
        }
    }

    // node ID
    $node_id = $op['node_info']['id'];
    // authentication
    if (isset($sysconf['node'][$node_id])) {
        // check for password
        if ($sysconf['node'][$node_id]['password'] === $op['node_info']['password']) {
            $action = $op['node_data']['operation'];
            $action_data = $op['node_data']['biblio'];
            // update/delete catalog data
            if ($action_data) {
                if ($action == 'delete') {
                    $_del = @$dbs->query("DELETE FROM biblio WHERE orig_biblio_id IN ($action_data) AND node_id='$node_id'");
                    $_deleted_num = $dbs->affected_rows;
                    // write log
                    utility::writeLogs($dbs, 'nodes', $op['node_info']['id'], 'ucs', 'Node '.$node_id.'('.$op['node_info']['name'].') delete '.$_deleted_num.' catalog data');
                    die(json_encode(array('status' => 'DELETED', 'message' => $_deleted_num.' catalog record(s) delete succesfully from '.$sysconf['server']['name'].'!')));
                }
            }
        } else {
            die(json_encode(array('status' => 'NOT_AUTHORIZED', 'message' => 'You not authorized to update data on server '.$sysconf['server']['name'].'! Please check your ucnode.inc.php file for correct configuration!')));
        }
    } else {
        die(json_encode(array('status' => 'NOT_AUTHORIZED', 'message' => 'You not authorized to update data on server '.$sysconf['server']['name'].'! Please check your ucnode.inc.php file for correct configuration!')));
    }
} else {
    die(json_encode(array('status' => 'NO_DATA', 'message' => 'Request is empty! Could be error on HTTP request')));
}
?>
