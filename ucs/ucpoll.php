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
require INC_DIR.'ucs_nodes_poll.inc.php';

// check total node poll
$total_conn = ucs_nodes_poll::check_poll($dbs);
if ($total_conn >= $sysconf['server']['max_node_all']) {
    die(json_encode(array('status' => 'POLL_MAX', 'message' => 'Sorry for inconvinience, server connection poll is busy right now. Please try again later')));
}

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
    $biblio = json_decode($body, true);
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
    $node_id = $biblio['node_info']['id'];
    // authentication
    if (isset($sysconf['node'][$node_id])) {
        // check for password
        if ($sysconf['node'][$node_id]['password'] === $biblio['node_info']['password']) {
            // check node poll
            $node_conn = ucs_nodes_poll::check_node_poll($dbs, $node_id);
            if ($node_conn >= $sysconf['server']['max_node_conn']) {
                die(json_encode(array('status' => 'NODE_POLL_MAX', 'message' => 'Your connection to server currently full. Please try again later')));
            }

            // master file reference cache
            $cache_author = array();
            $cache_subject = array();
            $cache_gmd = array();
            $cache_language = array();
            $cache_publisher = array();
            $cache_place = array();
            $cache_frequency = array();

            // set poll
            ucs_nodes_poll::set_node_poll($dbs, $node_id, $referer);

            // insert upload catalog data to database
            $r = 0;
            // prepare query
            $sql = "REPLACE INTO biblio (orig_biblio_id,gmd_id,title,edition,isbn_issn,publisher_id,publish_year,
                collation,series_title,call_number,language_id,publish_place_id,
                classification,notes,frequency_id,spec_detail_info,node_id,post_date,input_date,last_update)
                VALUES (%d,%d,'%s','%s','%s',%d,%d,'%s','%s','%s','%s',%d,'%s','%s',%d,'%s','%s','%s','%s','%s')";
            // execute statement
            foreach ($biblio['node_data'] as $data) {
                // SQL escaping string
                foreach ($data as $field => $val) {
                    if (is_string($val)) {
                        $data[$field] = $dbs->escape_string(trim($val));
                    }
                }

                // get current date
                $curr_date = date('Y-m-d H:i:s');

                // MASTER FILE FOREIGN KEY processing
                // gmd
                @$dbs->query('INSERT IGNORE INTO mst_gmd (gmd_code,gmd_name,input_date,last_update) VALUES (\''.$data['gmd_code'].'\', \''.$data['gmd_name'].'\', \''.$curr_date.'\', \''.$curr_date.'\')');
                $gmd_id = utility::getID($dbs, 'mst_gmd', 'gmd_id', 'gmd_name', $data['gmd_name'], $cache_gmd);

                $publisher_id = utility::getID($dbs, 'mst_publisher', 'publisher_id', 'publisher_name', $data['publisher_name'], $cache_publisher);
                $place_id = utility::getID($dbs, 'mst_place', 'place_id', 'place_name', $data['place_name'], $cache_place);

                @$dbs->query('INSERT IGNORE INTO mst_language (language_id,language_name,input_date,last_update) VALUES (\''.$data['language_id'].'\', \''.$data['language_name'].'\', \''.$curr_date.'\', \''.$curr_date.'\')');
                $language_id = utility::getID($dbs, 'mst_language', 'language_id', 'language_name', $data['language_name'], $cache_language);

                $frequency_id = $data['frequency']?utility::getID($dbs, 'mst_frequency', 'frequency_id', 'frequency', $data['frequency'], $cache_frequency):'NULL';

                // create original node biblio data
                $orig_biblio_id = $data['biblio_id'];
                // format SQL string
                $real_sql = sprintf($sql, $orig_biblio_id,$gmd_id,$data['title'],$data['edition'],$data['isbn_issn'],$publisher_id,$data['publish_year'],
                    $data['collation'],$data['series_title'],$data['call_number'],$language_id,$place_id,
                    $data['classification'],$data['notes'],1,$data['spec_detail_info'],$node_id,
                    $curr_date,$curr_date,$curr_date);
                // execute SQL query
                $dbs->query($real_sql);
                // get inserted biblio data
                $biblio_id = $dbs->insert_id;

                // check for errors
                if ($dbs->error) {
                    echo json_encode(array('status' => 'DB_ERROR', 'message' => 'Database error: '.$dbs->error.'! Maybe because same record(s) already uploaded to server!'));
                    // close poll
                    ucs_nodes_poll::clear_poll($dbs, $node_id);
                    die();
                } else {
                    // set authors
                    if ($data['authors']) {
                        $biblio_author_sql = 'INSERT IGNORE INTO biblio_author (biblio_id, author_id, level) VALUES ';
                        foreach ($data['authors'] as $author) {
                            $author['auth_list'] = $author['auth_list']?"'".$author['auth_list']."'":'NULL';
                            @$dbs->query('INSERT IGNORE INTO mst_author (author_name,authority_type,auth_list,input_date,last_update)
                                VALUES (\''.$author['name'].'\', \''.$author['type'].'\', '.$author['auth_list'].', \''.$curr_date.'\', \''.$curr_date.'\')');
                            $author['name'] = $dbs->escape_string(trim($author['name']));
                            $author_id = utility::getID($dbs, 'mst_author', 'author_id', 'author_name', $author['name'], $cache_author);
                            $biblio_author_sql .= " ($biblio_id, $author_id, ".$author['level']."),";
                        }
                        // remove last comma
                        $biblio_author_sql = substr_replace($biblio_author_sql, '', -1);
                        // execute query
                        $dbs->query($biblio_author_sql);
                        // echo $dbs->error;
                    }
                    // set topic
                    if ($data['subjects']) {
                        $biblio_subject_sql = 'INSERT IGNORE INTO biblio_topic (biblio_id, topic_id, level) VALUES ';
                        foreach ($data['subjects'] as $subject) {
                            $subject['auth_list'] = $subject['auth_list']?"'".$subject['auth_list']."'":'NULL';
                            @$dbs->query('INSERT IGNORE INTO mst_topic (topic,topic_type,auth_list,input_date,last_update)
                                VALUES (\''.$subject['name'].'\', \''.$subject['type'].'\', '.$subject['auth_list'].', \''.$curr_date.'\', \''.$curr_date.'\')');
                            $subject['name'] = $dbs->escape_string(trim($subject['name']));
                            $subject_id = utility::getID($dbs, 'mst_topic', 'topic_id', 'topic', $subject['name'], $cache_subject);
                            $biblio_subject_sql .= " ($biblio_id, $subject_id, ".$subject['level']."),";
                        }
                        // remove last comma
                        $biblio_subject_sql = substr_replace($biblio_subject_sql, '', -1);
                        // execute query
                        $dbs->query($biblio_subject_sql);
                        // echo $dbs->error;
                    }
                }
                $r++;
            }

            // close poll
            ucs_nodes_poll::clear_poll($dbs, $node_id);

            // write log
            utility::writeLogs($dbs, 'nodes', $biblio['node_info']['id'], 'ucs', 'Node '.$node_id.'('.$sysconf['node'][$node_id]['name'].') upload '.$r.' of catalog data');
            die(json_encode(array('status' => 'UPLOADED', 'message' => $r.' catalog record uploaded succesfully to '.$sysconf['server']['name'].'!')));
        } else {
            die(json_encode(array('status' => 'NOT_AUTHORIZED', 'message' => 'You not authorized to upload data to server '.$sysconf['server']['name'].'! Please check your ucnode.inc.php file for correct configuration!')));
        }
    } else {
        die(json_encode(array('status' => 'NOT_AUTHORIZED', 'message' => 'You not authorized to upload data to server '.$sysconf['server']['name'].'! Please check your ucnode.inc.php file for correct configuration!')));
    }
} else {
    die(json_encode(array('status' => 'NO_DATA', 'message' => 'Request is empty! Could be error on HTTP request')));
}
?>
