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

/* Quick Return page */

// key to authenticate
if (!defined('INDEX_AUTH')) {
    define('INDEX_AUTH', '1');
}

require '../../../sysconfig.inc.php';
// start the session
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';

// load settings from database
utility::loadSettings($dbs);

// privileges checking
$can_read = utility::havePrivilege('circulation', 'r');
$can_write = utility::havePrivilege('circulation', 'w');

if (!($can_read AND $can_write)) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to view this section').'</div>');
}

// check if quick return is enabled
if (!$sysconf['quick_return']) {
    die('<div class="errorBox">'.__('Quick Return is disabled').'</div');
}
?>

<fieldset class="menuBox">
<div class="menuBoxInner quickReturnIcon">
    <?php echo strtoupper(__('Quick Return')); ?> - <?php echo __('Insert an item ID to return collection with keyboard or barcode reader'); ?>
    <hr />
    <form class="notAJAX" action="<?php echo MODULES_WEB_ROOT_DIR; ?>circulation/ajax_action.php" target="circAction" method="post" style="display: inline;">
    <?php echo __('Item ID'); ?> :
    <input type="text" name="quickReturnID" id="quickReturnID" size="30" />
    <input type="submit" value="<?php echo __('Return'); ?>" class="button" />
    </form>
    <iframe name="circAction" id="circAction" style="display: inline; width: 5px; height: 5px; visibility: hidden;"></iframe>
</div>
</fieldset>
<div id="circulationLayer">&nbsp;</div>
