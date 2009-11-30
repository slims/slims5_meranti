<?php
/*
 * PHP-Barcode 0.3pl1

 * PHP-Barcode generates
 *   - Barcode-Images using libgd2 (png, jpg, gif)
 *   - HTML-Images (using 1x1 pixel and html-table)
 *   - silly Text-Barcodes
 *
 * PHP-Barcode encodes using
 *   - a built-in EAN-13/ISBN Encoder
 *   - genbarcode (by Folke Ashberg), a command line
 *     barcode-encoder which uses GNU-Barcode
 *     genbarcode can encode EAN-13, EAN-8, UPC, ISBN, 39, 128(a,b,c),
 *     I25, 128RAW, CBR, MSI, PLS
 *     genbarcode is available at www.ashberg.de/bar

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

/* MODIFIED BY : Arie Nugraha */
define('GD_NOT_LOADED', 1);
define('ENCODING_UNHANDLED', 2);

/* CONFIGURATION */
// color
$bar_color = array(0,0,0);
$bg_color = array(255,255,255);
$text_color = array(0,0,0);

// TTF font location
$font_loc = "./DejaVuSans.ttf";

// genbarcode binary location
if (stripos(PHP_OS, 'Darwin') !== false) {
    $genbarcode_loc = './bin/darwin/genbarcode';
} else if (stripos(PHP_OS, 'Linux') !== false) {
    $genbarcode_loc = './bin/nix/genbarcode';
} else {
    $genbarcode_loc = '.\bin\win\genbarcode.exe';
}

// default barcode filename
$barcode_text = 'barcode';

/* CONFIGURATION ENDS HERE */

require "encode_bars.php"; /* build-in encoders */

/*
 * barcode_outimage(text, bars [, scale [, mode [, total_y [, space ]]]] )
 *
 *  Outputs an image using libgd
 *
 *    text   : the text-line (<position>:<font-size>:<character> ...)
 *    bars   : where to place the bars  (<space-width><bar-width><space-width><bar-width>...)
 *    scale  : scale factor ( 1 < scale < unlimited (scale 50 will produce
 *                                                   5400x300 pixels when
 *                                                   using EAN-13!!!))
 *    mode   : png,gif,jpg, depending on libgd ! (default = 'png')
 *    total_y: the total height of the image ( default: scale * 60 )
 *    space  : space
 *             default:
 *      $space[top]   = 2 * $scale;
 *      $space[bottom] =  2 * $scale;
 *      $space[left]  = 2 * $scale;
 *      $space[right] = 2 * $scale;
 */

function barcode_outimage($text, $bars, $scale = 1, $mode = "png", $total_y = 0, $space = '')
{
    global $bar_color, $bg_color, $text_color;
    global $font_loc;
    global $barcode_text;
    /* set defaults */
    if ($scale<1) $scale = 2;
        $total_y = intval($total_y);

    if ($total_y < 1) $total_y = intval($scale * 60);
    if (!$space)
        $space = array( 'top' => 2*$scale, 'bottom' => 2*$scale, 'left' => 2*$scale, 'right' => 2*$scale);

    /* count total width */
    $xpos = 0;
    $width = true;
    for ($i = 0; $i < strlen($bars) ;$i++){
        $val = strtolower($bars[$i]);
        if ($width){
            $xpos +=  $val*$scale;
            $width = false;
            continue;
        }
        if (preg_match("@[a-z]@i", $val)) {
            /* tall bar */
            $val = ord($val)-ord('a')+1;
        }

        $xpos +=  $val*$scale;
        $width = true;
    }

    /* allocate the image */
    $total_x = ( $xpos )+$space['right']+$space['right'];
    $xpos = $space['left'];
    /* checking for GD library */
    if (!function_exists("imagecreate")) {
        return GD_NOT_LOADED;
    }

    $im = imagecreate($total_x, $total_y);
    /* create two images */
    $col_bg = ImageColorAllocate($im, $bg_color[0], $bg_color[1], $bg_color[2]);
    $col_bar = ImageColorAllocate($im, $bar_color[0], $bar_color[1], $bar_color[2]);
    $col_text = ImageColorAllocate($im, $text_color[0], $text_color[1], $text_color[2]);
    $height = round($total_y-($scale*10));
    $height2 = round($total_y-$space['bottom']);

    /* paint the bars */
    $width = true;
    for ($i = 0; $i < strlen($bars); $i++){
        $val = strtolower($bars[$i]);
        if ($width){
            $xpos += $val*$scale;
            $width = false;
            continue;
        }
        if (preg_match("@[a-z]@i", $val)){
            /* tall bar */
            $val = ord($val)-ord('a')+1;
            $h = $height2;
        } else
            $h = $height;

        imagefilledrectangle($im, $xpos, $space['top'], $xpos+($val*$scale)-1, $h, $col_bar);
        $xpos += $val*$scale;
        $width = true;
    }

    /* write out the text */
    $chars = explode(' ', $text);
    reset($chars);
    while (list($n, $v) = each($chars)) {
        if (trim($v)){
            $inf = explode(":", $v);
            $fontsize = $scale*($inf[1]/1.8);
            $fontheight = $total_y-($fontsize/2.7)+2;
            @imagettftext($im, $fontsize, 0, $space['left']+($scale*$inf[0])+2, $fontheight, $col_text, $font_loc, $inf[2]);
        }
    }

    $mode = strtolower($mode);
    /* replac any space in barcode text */
    $text = str_replace(' ', '_', $text);
    /* replace space */
    $barcode_text = str_replace(array(' ', '/', '\/'), '_', $barcode_text);
    /* replace invalid characters */
    $barcode_text = str_replace(array(':', ',', '*', '@'), '', $barcode_text);
    /* output the image */
    if ($mode == 'jpg' || $mode == 'jpeg'){
        header('Content-Type: image/jpeg');
        @imagejpeg($im, '../../images/barcodes/'.$barcode_text.'.jpg');
    } else if ($mode == 'gif'){
        header('Content-Type: image/gif');
        @imagegif($im, '../../images/barcodes/'.$barcode_text.'.gif');
    } else {
        header('Content-Type: image/png');
        @imagepng($im, '../../images/barcodes/'.$barcode_text.'.png');
    }
}


/* barcode_encode_genbarcode(code, encoding)
 *   encodes $code with $encoding using genbarcode
 *
 *   return:
 *    array[encoding] : the encoding which has been used
 *    array[bars]     : the bars
 *    array[text]     : text-positioning info
 */
function barcode_encode_genbarcode($code, $encoding){
    global $genbarcode_loc;
    /* delete EAN-13 checksum */
    if (preg_match("@^ean$@i", $encoding) && strlen($code) == 13) $code = substr($code,0,12);
    if (!$encoding) $encoding = 'ANY';
    $code = preg_replace('@\\\|\/@i', "_", $code);
    $cmd = $genbarcode_loc.' "'.$code."\" \"".strtoupper($encoding)."\"";
    $fp = popen($cmd, 'r');
    if ($fp) {
        $bars = fgets($fp, 1024);
        $text = fgets($fp, 1024);
        $encoding = fgets($fp, 1024);
        pclose($fp);
    } else {
        return false;
    }

    $ret = array(
        'encoding' => trim($encoding),
        'bars' => trim($bars),
        'text' => trim($text)
        );
    if (!$ret['encoding']) return false;
    if (!$ret['bars']) return false;
    if (!$ret['text']) return false;
    return $ret;
}


/* barcode_encode(code, encoding)
 *   encodes $code with $encoding using genbarcode OR built-in encoder
 *   if you don't have genbarcode only EAN-13/ISBN is possible
 *
 * You can use the following encodings (when you have genbarcode):
 *   ANY    choose best-fit (default)
 *   EAN    8 or 13 EAN-Code
 *   UPC    12-digit EAN
 *   ISBN   isbn numbers (still EAN-13)
 *   39     code 39
 *   128    code 128 (a,b,c: autoselection)
 *   128C   code 128 (compact form for digits)
 *   128B   code 128, full printable ascii
 *   I25    interleaved 2 of 5 (only digits)
 *   128RAW Raw code 128 (by Leonid A. Broukhis)
 *   CBR    Codabar (by Leonid A. Broukhis)
 *   MSI    MSI (by Leonid A. Broukhis)
 *   PLS    Plessey (by Leonid A. Broukhis)
 *
 *   return:
 *    array[encoding] : the encoding which has been used
 *    array[bars]     : the bars
 *    array[text]     : text-positioning info
 */
function barcode_encode($code, $encoding){
    global $genbarcode_loc;
    if (
        ((preg_match("@^ean$@i", $encoding)
         && ( strlen($code) == 12 || strlen($code) == 13)))

        || (($encoding) && (preg_match("@^isbn$@i", $encoding))
         && (( strlen($code) == 9 || strlen($code) == 10) ||
         (((preg_match("@^978@i", $code) && strlen($code) == 12) ||
          (strlen($code) == 13)))))

        || (( !isset($encoding) || !$encoding || (preg_match("@^ANY$@i", $encoding) ))
         && (preg_match("@^[0-9]{12,13}$@i", $code)))

        ) {
        /* use built-in EAN-Encoder */
        $bars = barcode_encode_ean($code, $encoding);
    } else if (file_exists($genbarcode_loc)) {
        /* use genbarcode */
        $bars = barcode_encode_genbarcode($code, $encoding);
    } else {
        return ENCODING_UNHANDLED;
    }
    return $bars;
}


/* barcode_print(code [, encoding [, scale [, mode ]]] );
 *
 *  encodes and prints a barcode
 *
 *   return:
 *    array[encoding] : the encoding which has been used
 *    array[bars]     : the bars
 *    array[text]     : text-positioning info
 */
function barcode_print($code, $encoding = '128B', $scale = 2 ,$mode = 'png' )
{
    global $barcode_text;
    $barcode_text = $code;
    // encode barcode
    $bars = barcode_encode($code, $encoding);
    if ($bars == ENCODING_UNHANDLED) {
        return false;
    }
    // set filetype mode
    if (!$mode) {
        $mode = 'png';
    }
    // output the image
    barcode_outimage($bars['text'], $bars['bars'], $scale, $mode);
}
?>
