<?php
/*

 * Image-Creator / Sample
 * Part of PHP-Barcode 0.3pl1

 * (C) 2001,2002,2003,2004 by Folke Ashberg <folke@ashberg.de>

 * The newest version can be found at http://www.ashberg.de/bar

 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

 */

/*
 * call
 * http://localhost/barcode.php?code=012345678901
 *   or
 * http://localhost/barcode.php?code=012345678901&encoding=EAN&scale=4&mode=png
 *
 */
 
// include php-barcode lib
require "php-barcode.php";

// http vars
$code = trim($_GET['code']);
$encoding = trim($_GET['encoding']);
$scale = trim($_GET['scale']);
$mode = trim($_GET['mode']);

// output the barcode
barcode_print($code, $encoding, $scale, $mode);
?>