<?php
/**
 *
 * SESSION Settings
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 * Taken and modified from phpMyAdmin's Session library
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

// always use session cookies
@ini_set('session.use_cookies', true);
// but not all user allow cookies
// @ini_set('session.use_only_cookies', false);
// @ini_set('session.use_trans_sid', true);
// delete session/cookies when browser is closed
// @ini_set('session.cookie_lifetime', 0);
// warn but dont work with bug
// @ini_set('session.bug_compat_42', false);
// @ini_set('session.bug_compat_warn', true);
// use more secure session ids
@ini_set('session.hash_function', 1);
// some pages (e.g. stylesheet) may be cached on clients, but not in shared proxy servers
@session_cache_limiter('private');
// set session name and start the session
@session_name(SENAYAN_SESSION_COOKIES_NAME);
// set session cookies params
@session_set_cookie_params(86400, SENAYAN_WEB_ROOT_DIR);
// start session
@session_start();
?>
