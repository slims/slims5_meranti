<?php
/**
 * admin_logon class
 * Class for user authentication
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

class admin_logon
{
    protected $username = '';
    protected $password = '';
    public $real_name = '';
    public $ip_check = '';


    /**
     * Class Constructor
     *
     * @param   string  $str_username
     * @param   string  $str_password
     */
    public function __construct($str_username, $str_password)
    {
        $this->username = $str_username;
        $this->password = $str_password;
    }


    /**
     * Method to check user validity
     *
     * @param   object  $obj_db
     * @return  void
     */
    public function adminValid($obj_db)
    {
        $_sql_librarian_login = sprintf("SELECT
            u.user_id,
            u.username,
            u.realname,
            u.groups
            FROM user AS u
            WHERE u.username='%s'
                AND u.passwd=MD5('%s')", $obj_db->escape_string(trim($this->username)), $obj_db->escape_string(trim($this->password)));
        $_user_q = $obj_db->query($_sql_librarian_login);

        // error check
        if ($obj_db->error) {
            echo '<div style="border: 1px dotted #FF0000; color: #FF0000; padding: 5px; margin: 3px;">'.__('Error authenticating user and password to database').'</div>';
            return false;
        }

        // check if the user exist in database
        if ($_user_q->num_rows < 1) {
            return false;
        } else {
            // if the ip checking is enabled
            if ($this->ip_check) {
                if ($this->ip_check != $_SERVER['REMOTE_ADDR']) {
                    return false;
                }
            }

            $_user_d = $_user_q->fetch_assoc();
            $this->real_name = $_user_d['realname'];
            // fill all sessions var
            $_SESSION['uid'] = $_user_d['user_id'];
            $_SESSION['uname'] = $_user_d['username'];
            $_SESSION['realname'] = $_user_d['realname'];
            if (!empty($_user_d['groups'])) {
                $_SESSION['groups'] = @unserialize($_user_d['groups']);
                // fetch group privileges
                foreach ($_SESSION['groups'] as $group_id) {
                    $_priv_q = $obj_db->query('SELECT ga.*,mdl.module_path FROM group_access AS ga
                        LEFT JOIN mst_module AS mdl ON ga.module_id=mdl.module_id WHERE ga.group_id='.$group_id);
                    while ($_priv_d = $_priv_q->fetch_assoc()) {
                        // init privileges
                        // $_SESSION['priv'][$_priv_d['module_path']]['r'] = false;
                        // $_SESSION['priv'][$_priv_d['module_path']]['w'] = false;
                        if ($_priv_d['r']) {
                            $_SESSION['priv'][$_priv_d['module_path']]['r'] = true;
                        }
                        if ($_priv_d['w']) {
                            $_SESSION['priv'][$_priv_d['module_path']]['w'] = true;
                        }
                    }
                }
            } else {
                $_SESSION['groups'] = null;
            }

            $_SESSION['logintime'] = time();
            // session vars needed by some application modules
            $_SESSION['temp_loan'] = array();
            $_SESSION['biblioAuthor'] = array();
            $_SESSION['biblioTopic'] = array();
            $_SESSION['biblioAttach'] = array();

            if (!defined('UCS_VERSION')) {
                // load holiday data from database
                $_holiday_dayname_q = $obj_db->query('SELECT holiday_dayname FROM holiday WHERE holiday_date IS NULL');
                $_SESSION['holiday_dayname'] = array();
                while ($_holiday_dayname_d = $_holiday_dayname_q->fetch_row()) {
                    $_SESSION['holiday_dayname'][] = $_holiday_dayname_d[0];
                }

                $_holiday_date_q = $obj_db->query('SELECT holiday_date FROM holiday WHERE holiday_date IS NOT NULL
                    ORDER BY holiday_date DESC LIMIT 365');
                $_SESSION['holiday_date'] = array();
                while ($_holiday_date_d = $_holiday_date_q->fetch_row()) {
                    $_SESSION['holiday_date'][$_holiday_date_d[0]] = $_holiday_date_d[0];
                }
            }

            // save md5sum of  current application path
            $_SESSION['checksum'] = defined('UCS_BASE_DIR')?md5($_SERVER['SERVER_ADDR'].UCS_BASE_DIR.'admin'):md5($_SERVER['SERVER_ADDR'].SENAYAN_BASE_DIR.'admin');

            // update the last login time
            $obj_db->query("UPDATE user SET last_login='".date("Y-m-d H:i:s")."',
                last_login_ip='".$_SERVER['REMOTE_ADDR']."'
                WHERE user_id=".$_user_d['user_id']);

            return true;
        }

        return false;
    }
}
?>
