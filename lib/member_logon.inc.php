<?php
/**
 * Member Login class
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

class member_logon
{
    protected $username = '';
    protected $password = '';

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
    public function valid($obj_db)
    {
        $_sql_member_login = sprintf("SELECT m.member_id, m.member_name, m.inst_name,
            m.member_email, m.expire_date, m.register_date, m.is_pending,
            m.member_type_id, mt.member_type_name
            FROM member AS m LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id
            WHERE m.member_id='%s'
                AND m.mpasswd=MD5('%s')", $obj_db->escape_string(trim($this->username)), $obj_db->escape_string(trim($this->password)));
        $_member_q = $obj_db->query($_sql_member_login);

        // error check
        if ($obj_db->error) {
            echo '<div style="border: 1px dotted #FF0000; color: #FF0000; padding: 5px; margin: 3px;">'.__('Error authenticating user and password to database').'</div>';
            return false;
        }

        // check if the user exist in database
        if ($_member_q->num_rows < 1) {
            return false;
        } else {
            // fetch data
            $_member_d = $_member_q->fetch_assoc();

            // fill all sessions var
            $_SESSION['mid'] = $_member_d['member_id'];
            $_SESSION['m_name'] = $_member_d['member_name'];
            $_SESSION['m_email'] = $_member_d['member_email'];
            $_SESSION['m_institution'] = $_member_d['inst_name'];
            $_SESSION['m_logintime'] = time();
            $_SESSION['m_expire_date'] = $_member_d['expire_date'];
            $_SESSION['m_member_type_id'] = $_member_d['member_type_id'];
            $_SESSION['m_member_type'] = $_member_d['member_type_name'];
            $_SESSION['m_register_date'] = $_member_d['register_date'];
            $_SESSION['m_membership_pending'] = intval($_member_d['is_pending'])?true:false;
            $_SESSION['m_is_expired'] = false;
            // check member expiry date
            require_once SIMBIO_BASE_DIR.'simbio_UTILS/simbio_date.inc.php';
            $_curr_date = date('Y-m-d');
            if (simbio_date::compareDates($_member_d['expire_date'], $_curr_date) == $_curr_date) {
                $_SESSION['m_is_expired'] = true;
            }
            // save md5sum of current application path
            // $_SESSION['checksum'] = md5($_SERVER['SERVER_ADDR'].SENAYAN_BASE_DIR);

            // update the last login time
            $obj_db->query("UPDATE member SET last_login='".date("Y-m-d H:i:s")."',
                last_login_ip='".$_SERVER['REMOTE_ADDR']."'
                WHERE member_id='".$_member_d['member_id']."'");

            return true;
        }
        return false;
    }
}
?>
