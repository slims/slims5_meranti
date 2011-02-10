<?php
/*
Heavily modified for SLiMS by Hendro Wicaksono (hendrowicaksono@yahoo.com)
(Senayan Library Management System), http://slims.web.id / http://senayan.diknas.go.id
It is derived from:
---------------------
MINIGAL NANO
- A PHP/HTML/CSS based image gallery script
This script and included files are subject to licensing from Creative Commons (http://creativecommons.org/licenses/by-sa/2.5/)
You may use, edit and redistribute this script, as long as you pay tribute to the original author by NOT removing the linkback to www.minigal.dk ("Powered by MiniGal Nano x.x.x")
MiniGal Nano is created by Thomas Rybak
Copyright 2010 by Thomas Rybak
Support: www.minigal.dk
Community: www.minigal.dk/forum
Please enjoy this free script!
USAGE EXAMPLE:
File: createthumb.php
Example: <img src="createthumb.php?filename=photo.jpg&amp;width=100&amp;height=100">
----------------------
Updated Example: $size is not used. Only width and height.
*/
//	error_reporting(E_ALL);

// Define variables
$target = "";
$xoord = 0;
$yoord = 0;
$default_res_width = 42;
$cache['enable'] = false;
$cache['folder'] = '../../images/cache/'; # try absolutely in case of error about safe mode in PHP
$cache['exist'] = false;
$cache['handle'] = '';

# Only accept JPG, PNG, GIF
if (!((preg_match("/.jpg$|.jpeg$/i", $_GET['filename'])) OR (preg_match("/.gif$/i", $_GET['filename'])) OR (preg_match("/.png$/i", $_GET['filename'])))) {
	header('Content-type: image/png');
    readfile('wrongcontenttype.png');
    exit;
}

// Display error image if file isn't found
if (!is_file($_GET['filename'])) {
    header('Content-type: image/png');
    readfile('filenotfound.png');
    exit;
}

// Display error image if file exists, but can't be opened
if (substr(decoct(fileperms($_GET['filename'])), -1, strlen(fileperms($_GET['filename']))) < 4 OR substr(decoct(fileperms($_GET['filename'])), -3,1) < 4) {
	header('Content-type: image/png');
    readfile('filecantbeopened.png');
    exit;
}

$imgsize = GetImageSize($_GET['filename']);
$width = $imgsize[0];
$height = $imgsize[1];

if ((isset($_GET['width'])) AND (trim($_GET['width']) != '')) {
    $res_width = $_GET['width'];
} else {
    $res_width = $default_res_width;
}

if ((isset($_GET['height'])) AND (trim($_GET['height']) != '')) {
    $res_height = $_GET['height'];
} else {
    $res_height = ($res_width / $width) * $height;
}

$cache['prefix'] = '_slims_img_cache_'.$res_width.'_x_'.$res_height.'_';
$cache['file'] = $cache['folder'].$cache['prefix'].basename($_GET['filename']);

function genContentType()
{
    if (preg_match("/.jpg$|.jpeg$/i", $_GET['filename'])) header('Content-type: image/jpeg');
    if (preg_match("/.gif$/i", $_GET['filename'])) header('Content-type: image/gif');
    if (preg_match("/.png$/i", $_GET['filename'])) header('Content-type: image/png');
}

if (file_exists($cache['file'])) {
    $cache['exist'] = true;
    genContentType();
    readfile($cache['file']);
    exit;
} else {
    $cache['exist'] = false;
}

genContentType();

// Rotate JPG pictures
if (preg_match("/.jpg$|.jpeg$/i", $_GET['filename'])) {
    if (function_exists('exif_read_data') && function_exists('imagerotate')) {
        $exif = exif_read_data($_GET['filename']);
        $ort = $exif['IFD0']['Orientation'];
		$degrees = 0;
		switch($ort) {
		    case 6: // 90 rotate right
		        $degrees = 270;
		    break;
		    case 8:    // 90 rotate left
		        $degrees = 90;
		    break;
		}
		if ($degrees != 0)	$target = imagerotate($target, $degrees, 0);
	}
}

$target = ImageCreatetruecolor($res_width,$res_height);
if (preg_match("/.jpg$/i", $_GET['filename'])) $source = ImageCreateFromJPEG($_GET['filename']);
if (preg_match("/.gif$/i", $_GET['filename'])) $source = ImageCreateFromGIF($_GET['filename']);
if (preg_match("/.png$/i", $_GET['filename'])) $source = ImageCreateFromPNG($_GET['filename']);
imagecopyresampled($target,$source,0,0,$xoord,$yoord,$res_width,$res_height,$width,$height);
imagedestroy($source);

if ($cache['exist'] == false) {
    if (preg_match("/.jpg$/i", $_GET['filename'])) {
        ImageJPEG($target,null,90);
        ImageJPEG($target,$cache['file'],90);
    }
    if (preg_match("/.gif$/i", $_GET['filename'])) {
        ImageJPEG($target,null,90);
        ImageJPEG($target,$cache['file'],90);
    }
    if (preg_match("/.png$/i", $_GET['filename'])) {
        ImageJPEG($target,null,90);
        ImageJPEG($target,$cache['file'],90);
    }
}         

imagedestroy($target);

?>