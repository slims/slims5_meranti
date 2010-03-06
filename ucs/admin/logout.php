<?php
/**
 * Copyright (C) 2010  Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com)
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

/* UCS console logout */

// required file
require '../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';

// write log
utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' Log Out from application from address '.$_SERVER['REMOTE_ADDR']);
// redirecting pages
$msg = '<script type="text/javascript">';
$msg .= 'alert(\''.__('You Have Been Logged Out From Union Catalog Server console').'\');';
$msg .= 'location.href = \''.UCS_WEB_ROOT_DIR.'index.php?p=login\';';
$msg .= '</script>';
// unset admin cookie flag
setcookie('admin_logged_in', true, time()-86400, UCS_WEB_ROOT_DIR);
// completely destroy session cookie
simbio_security::destroySessionCookie($msg, UCS_SESSION_COOKIES_NAME, UCS_WEB_ROOT_DIR.'admin/', true);
?>
