<?php
/**
 * utility class
 * A Collection of static utility methods
 *
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

// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) { 
    die("can not access this file directly");
}

class utility
{
    /**
     * Static Method to send out javascript alert
     *
     * @param   string  $str_message
     * @return  void
     */
    public static function jsAlert($str_message)
    {
        if (!$str_message) {
            return;
        }

        // replace newline with javascripts newline
        $str_message = str_replace("\n", '\n', $str_message);
        echo '<script type="text/javascript">'."\n";
        echo 'alert("'.addslashes($str_message).'")'."\n";
        echo '</script>'."\n";
    }


    /**
     * Static Method to load application settings from database
     *
     * @param   object  $obj_db
     * @return  void
     */
    public static function loadSettings($obj_db)
    {
        global $sysconf;
        $_setting_query = $obj_db->query('SELECT * FROM setting');
        if (!$obj_db->errno) {
            while ($_setting_data = $_setting_query->fetch_assoc()) {
                $_value = unserialize($_setting_data['setting_value']);
                if (is_array($_value)) {
                    foreach ($_value as $_idx=>$_curr_value) {
                        $sysconf[$_setting_data['setting_name']][$_idx] = $_curr_value;
                    }
                } else {
                    $sysconf[$_setting_data['setting_name']] = $_value;
                }
            }
        }
    }


    /**
     * Static Method to check privileges of application module form current user
     *
     * @param   string  $str_module_name
     * @param   string  $str_privilege_type
     * @return  boolean
     */
    public static function havePrivilege($str_module_name, $str_privilege_type = 'r')
    {
        // checking checksum
        $_checksum = defined('UCS_BASE_DIR')?md5($_SERVER['SERVER_ADDR'].UCS_BASE_DIR.'admin'):md5($_SERVER['SERVER_ADDR'].SENAYAN_BASE_DIR.'admin');
        if ($_SESSION['checksum'] != $_checksum) {
            return false;
        }
        // check privilege type
        if (!in_array($str_privilege_type, array('r', 'w'))) {
            return false;
        }
        if (isset($_SESSION['priv'][$str_module_name][$str_privilege_type]) AND $_SESSION['priv'][$str_module_name][$str_privilege_type]) {
            return true;
        }
        return false;
    }


    /**
     * Static Method to write application activities logs
     *
     * @param   object  $obj_db
     * @param   string  $str_log_type
     * @param   string  $str_value_id
     * @param   string  $str_location
     * @param   string  $str_log_msg
     * @return  void
     */
    public static function writeLogs($obj_db, $str_log_type, $str_value_id, $str_location, $str_log_msg)
    {
        if (!$obj_db->error) {
            // log table
            $_log_date = date('Y-m-d H:i:s');
            $_log_table = 'system_log';
            // filter input
            $str_log_type = $obj_db->escape_string(trim($str_log_type));
            $str_value_id = $obj_db->escape_string(trim($str_value_id));
            $str_location = $obj_db->escape_string(trim($str_location));
            $str_log_msg = $obj_db->escape_string(trim($str_log_msg));
            // insert log data to database
            @$obj_db->query('INSERT INTO '.$_log_table.'
            VALUES (NULL, \''.$str_log_type.'\', \''.$str_value_id.'\', \''.$str_location.'\', \''.$str_log_msg.'\', \''.$_log_date.'\')');
        }
    }


    /**
     * Static Method to get an ID of database table record
     *
     * @param   object  $obj_db
     * @param   string  $str_table_name
     * @param   string  $str_id_field
     * @param   string  $str_value_field
     * @param   string  $str_value
     * @param   array   $arr_cache
     * @return  mixed
     */
    public static function getID($obj_db, $str_table_name, $str_id_field, $str_value_field, $str_value, &$arr_cache = false)
    {
        $str_value = trim($str_value);
        if ($arr_cache) {
            if (isset($arr_cache[$str_value])) {
                return $arr_cache[$str_value];
            }
        }
        if (!$obj_db->error) {
            $id_q = $obj_db->query('SELECT '.$str_id_field.' FROM '.$str_table_name.' WHERE '.$str_value_field.'=\''.$obj_db->escape_string($str_value).'\'');
            if ($id_q->num_rows > 0) {
                $id_d = $id_q->fetch_row();
                unset($id_q);
                // cache
                if ($arr_cache) {
                    $arr_cache[$str_value] = $id_d[0];
                }
                return $id_d[0];
            } else {
                $_curr_date = date('Y-m-d');
                // if not found then we insert it as new value
                $obj_db->query('INSERT IGNORE INTO '.$str_table_name.' ('.$str_value_field.', input_date, last_update)
                    VALUES (\''.$obj_db->escape_string($str_value).'\', \''.$_curr_date.'\', \''.$_curr_date.'\')');
                if (!$obj_db->error) {
                    // cache
                    if ($arr_cache) {
                        $arr_cache[$str_value] = $obj_db->insert_id;
                    }
                    return $obj_db->insert_id;
                }
            }
        }
    }


    /**
     * Static method to detect mobile browser
     * Some Patches by Indra Sutriadi
     *
     * @return  boolean
     * this script is taken from http://mobiforge.com/developing/story/lightweight-device-detection-php
     **/
    public static function isMobileBrowser()
    {
        $_is_mobile_browser = '0';

        if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower(@$_SERVER['HTTP_USER_AGENT']))) {
            $_is_mobile_browser++;
        }

        if((strpos(strtolower(@$_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $_is_mobile_browser++;
        }

        $_mobile_ua = strtolower(substr(@$_SERVER['HTTP_USER_AGENT'],0,4));
        $_mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda','xda-');

        if(in_array($_mobile_ua, $_mobile_agents)) {
            $_is_mobile_browser++;
        }

        if (isset($_SERVER['ALL_HTTP']) && strpos(strtolower($_SERVER['ALL_HTTP']),'operamini')>0) {
            $_is_mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']),' ppc;')>0) {
            $_is_mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']),'windows ce')>0) {
            $_is_mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']),'windows')>0) {
            $_is_mobile_browser=0;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_USER_AGENT']),'iemobile')>0) {
            $_is_mobile_browser++;
        }

        if (strpos(strtolower(@$_SERVER['HTTP_ACCEPT']),'j2me')>0 || strpos(strtolower(@$_SERVER['HTTP_ACCEPT']),'midp')>0) {
            $_is_mobile_browser++;
        }

        if (isset($_SERVER['HTTP_X_OPERAMINI_PHONE'])) {
            $_is_mobile_browser++;
        }

        if ($_is_mobile_browser > 0) {
            return true;
        }
        return false;
    }


    /**
     * Static method to check if member already logged in or not
     *
     * @return  boolean
     **/
    public static function isMemberLogin()
    {
        $_logged_in = false;
        $_logged_in = isset($_SESSION['mid']) && isset($_SESSION['m_name']) && isset($_SESSION['m_email']);
        return $_logged_in;
    }
}
?>
