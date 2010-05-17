<?php
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
    $id_q = $dbs->query('SELECT author_id FROM mst_author WHERE author_name=\''.$str_value.'\'');
    if ($id_q->num_rows > 0) {
        $id_d = $id_q->fetch_row();
        unset($id_q);
        // cache
        if ($arr_cache) { $arr_cache[$str_value] = $id_d[0]; }
        return $id_d[0];
    } else {
        $_curr_date = date('Y-m-d');
        // if not found then we insert it as new value
        $dbs->query('INSERT IGNORE INTO mst_author (author_name, authority_type, input_date, last_update)'
            .' VALUES (\''.$str_value.'\', \''.$str_author_type.'\', \''.$_curr_date.'\', \''.$_curr_date.'\')');
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
    $id_q = $dbs->query('SELECT topic_id FROM mst_topic WHERE topic=\''.$str_value.'\'');
    if ($id_q->num_rows > 0) {
        $id_d = $id_q->fetch_row();
        unset($id_q);
        // cache
        if ($arr_cache) { $arr_cache[$str_value] = $id_d[0]; }
        return $id_d[0];
    } else {
        $_curr_date = date('Y-m-d');
        // if not found then we insert it as new value
        $dbs->query('INSERT IGNORE INTO mst_topic (topic, topic_type, input_date, last_update)'
            .' VALUES (\''.$str_value.'\', \''.$str_subject_type.'\', \''.$_curr_date.'\', \''.$_curr_date.'\')');
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
