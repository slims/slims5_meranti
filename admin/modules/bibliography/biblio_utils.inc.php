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

/**
 * Utility function to get author ID
 **/
function getAuthorID($str_author_name, $str_author_type, &$arr_cache = false)
{
    global $dbs;
    $str_value = trim($str_author_name);
    if ($arr_cache) {
        if (isset($arr_cache[$str_value])) {
            return $arr_cache[$str_value];
        }
    }

    $str_value = $dbs->escape_string($str_value);
    $_sql_id_q = sprintf('SELECT author_id FROM mst_author WHERE author_name=\'%s\'', $str_value);
    $id_q = $dbs->query($_sql_id_q);
    if ($id_q->num_rows > 0) {
        $id_d = $id_q->fetch_row();
        unset($id_q);
        // cache
        if ($arr_cache) { $arr_cache[$str_value] = $id_d[0]; }
        return $id_d[0];
    } else {
        $_curr_date = date('Y-m-d');
        // if not found then we insert it as new value
        $_sql_insert_author = sprintf('INSERT IGNORE INTO mst_author (author_name, authority_type, input_date, last_update)'
            .' VALUES (\'%s\', \'%s\', \'%s\', \'%s\')', $str_value, $str_author_type, $_curr_date, $_curr_date);
        $dbs->query($_sql_insert_author);
        if (!$dbs->error) {
            // cache
            if ($arr_cache) { $arr_cache[$str_value] = $dbs->insert_id; }
            return $dbs->insert_id;
        }
    }
}


/**
 * Utility function to get subject ID
 **/
function getSubjectID($str_subject, $str_subject_type, &$arr_cache = false)
{
    global $dbs;
    $str_value = trim($str_subject);
    if ($arr_cache) {
        if (isset($arr_cache[$str_value])) {
            return $arr_cache[$str_value];
        }
    }

    $str_value = $dbs->escape_string($str_value);
    $_sql_id_q = sprintf('SELECT topic_id FROM mst_topic WHERE topic=\'%s\'', $str_value);
    $id_q = $dbs->query($_sql_id_q);
    if ($id_q->num_rows > 0) {
        $id_d = $id_q->fetch_row();
        unset($id_q);
        // cache
        if ($arr_cache) { $arr_cache[$str_value] = $id_d[0]; }
        return $id_d[0];
    } else {
        $_curr_date = date('Y-m-d');
        // if not found then we insert it as new value
        $_sql_insert_topic = sprintf('INSERT IGNORE INTO mst_topic (topic, topic_type, input_date, last_update)'
            .' VALUES (\'%s\', \'%s\', \'%s\', \'%s\')', $str_value, $str_subject_type, $_curr_date, $_curr_date);
        $dbs->query($_sql_insert_topic);
        if (!$dbs->error) {
            // cache
            if ($arr_cache) { $arr_cache[$str_value] = $dbs->insert_id; }
            return $dbs->insert_id;
        } else {
            echo $dbs->error;
        }
    }
}
?>
