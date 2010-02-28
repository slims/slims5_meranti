<?php
/**
 * Database connection
 *
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com), Wardiyono (wynerst@gmail.com)
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

// we prefer to use mysqli extensions if its available
if (extension_loaded('mysqli')) {
    /* MYSQLI */
    $dbs = @new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
    if (mysqli_connect_error()) {
        die('<div style="border: 1px dotted #FF0000; color: #FF0000; padding: 5px;">Error Connecting to Database. Please check your configuration</div>');
    }
} else {
    /* MYSQL */
    // require the simbio mysql class
    include SIMBIO_BASE_DIR.'simbio_DB/mysql/simbio_mysql.inc.php';
    // make a new connection object that will be used by all applications
    $dbs = @new simbio_mysql(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
}
?>
